<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marry_assistances', function (Blueprint $table) {
           $table->enum('status', ['منفذ', 'مطلوب'])->default('مطلوب')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marry_assistances', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
