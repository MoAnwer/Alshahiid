<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class SettingController extends Controller
{
    protected $mysqldumpPath;
    protected $mysqlPath;
    protected $backupFile;
    protected $dbHost;
    protected $dbUser;
    protected $dbName;
    protected $dbPassword;

    public function __construct() {
        $this->mysqldumpPath =  config('database.mysqldump_path');
        $this->mysqlPath = config('database.mysql_path');
        $this->backupFile = 'backup.sql';
        $this->dbHost = config('database.connections.mysql.host');
        $this->dbUser = config('database.connections.mysql.username');
        $this->dbName = config('database.connections.mysql.database');
        $this->dbPassword = config('database.connections.mysql.password');
    }

    public function settingPage() 
    {
        $fileSize = '0KB';
        $fileLastModified = '00-00-00';

        if(Storage::exists($this->backupFile)) {
            $fileSize = $this->getFileSize(Storage::fileSize($this->backupFile));
            $fileLastModified = date('d-m-Y h:i:sa', Storage::lastModified($this->backupFile));
        }
        return view('admin.settings', compact('fileSize', 'fileLastModified'));
    }

    /**
     * Get the size of file 
     * @param string file name
     **/
    
    function getFileSize($file) {
        if (($file) >= 24 && ($file) <= 1024*1024 ) {
            return round(($file) / 1024 , 1) + 1 . "KB";
        } elseif (($file) >= 1024*1024 && ($file) <= 1024*1024*1024) {
            return round(($file) / 1024 / 1024 , 1) . "MB";
        } elseif (($file) >= 1024*1024*1024) {
            return round(($file) / 1024 / 1024 / 1024, 1) . "GB";
        } else {
            return "0kb";
        }
    }

    public function backup()
    {
        $backupDir = storage_path('app');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0775, true);
        }

        $backupFilePath = $backupDir . '/backup.sql';

        ini_set('max_execution_time', 4800);
        
        $command = "{$this->mysqldumpPath} --user=$this->dbUser --host=$this->dbHost -p{$this->dbPassword} $this->dbName > $backupFilePath";

        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            return back()->with('success', 'تم إنشاء نسخة احتياطية بنجاح');
        } else {
            return back()->with('error', 'حدث خطأ ' . $command);
        }
    }


    public function importBackup(Request $request)
    {
        // Check if the fle uploaded
        if (!$request->hasFile('backup_file')) {
            return response()->json(['message' => 'يرجى رفع ملف النسخة الاحتياطية!'], 400);
        }

        // Save file in storage path
        $backupFile = $request->file('backup_file');
        $backupPath = storage_path('app/imported_backups/' . $backupFile->getClientOriginalName());
        $backupFile->move(storage_path('app/imported_backups/'), $backupFile->getClientOriginalName());

        // import backup command
        $command = "{$this->mysqlPath} --user={$this->dbUser} --database={$this->dbName} -p{$this->dbPassword} < {$backupPath}";

        ini_set('max_execution_time', 5800);

        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            return back()->with('success', 'تم استيراد قاعدة البيانات بنجاح');
        } else {
            return back()->with('error', 'حدث خطأ ' . $command);
        }

        return response()->json(['message' => 'تم استيراد قاعدة البيانات بنجاح!']);

    }

    public function downloadBackup() 
    {  
        $file_path = storage_path('app/public/'.$this->backupFile);
        $originalName = pathinfo($file_path, PATHINFO_FILENAME);
        $EXTENSION = pathinfo($file_path, PATHINFO_EXTENSION);
        $date = now()->format('Y-m-d_H:i:s');
        $newFileName = "{$originalName}_{$date}.{$EXTENSION}";

        return Storage::download($this->backupFile, $newFileName);
    }
}
