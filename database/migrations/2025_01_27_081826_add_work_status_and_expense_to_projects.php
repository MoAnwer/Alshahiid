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
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('work_status', ['لا يعمل', 'يعمل'])->after('status');
            $table->decimal('monthly_budget', 15, 2)->nullable()->after('budget_out_of_org');
            $table->decimal('expense', 15, 2)->nullable()->after('monthly_budget');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumns(['work_status', 'monthly_budget', 'expense']);
        });
    }
};
