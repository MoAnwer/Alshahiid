<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class SettingController extends Controller
{
    protected $backupFile = 'backups/alshahiid.sql';

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
     * getFileSize 
     * @param string filename
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
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbUser = env('DB_USERNAME', 'root');
        $dbDatabase = env('DB_DATABASE', 'alshahiid');

        $backupDir = storage_path('app/backups');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0775, true);
        }

        $mysqldumpPath = '"D:\\xampp\\mysql\\bin\\mysqldump.exe"';

        $backupFile = $backupDir . '\alshahiid.sql';

        ini_set('max_execution_time', 1800);
        
        $command = "{$mysqldumpPath} --user=$dbUser --host=$dbHost $dbDatabase > $backupFile";

        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            return back()->with('success', 'تم إنشاء نسخة احتياطية بنجاح');
        } else {
            return back()->with('error', 'حدث خطأ');
        }
    }


    public function importBackup(Request $request)
    {
        // التحقق من أن الملف تم رفعه
        if (!$request->hasFile('backup_file')) {
            return response()->json(['message' => 'يرجى رفع ملف النسخة الاحتياطية!'], 400);
        }

        // جلب بيانات قاعدة البيانات من .env
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');
        $dbName = env('DB_DATABASE', 'testingBackup');

        // حفظ الملف في مجلد التخزين
        $backupFile = $request->file('backup_file');
        $backupPath = storage_path('app/imported_backups/' . $backupFile->getClientOriginalName());
        $backupFile->move(storage_path('app/imported_backups/'), $backupFile->getClientOriginalName());

        
        // تحديد المسار الصحيح لـ mysql في XAMPP
        $mysqlPath = 'D:\xampp\mysql\bin\mysql.exe';
        
        // أمر الاستيراد
        $command = "{$mysqlPath} --user={$dbUser} --database={$dbName} < {$backupPath}";
        // dd($command);

        ini_set('max_execution_time', 1800);

        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            return back()->with('success', 'تم استيراد قاعدة البيانات بنجاح');
        } else {
            return back()->with('error', 'حدث خطأ');
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
