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
        Schema::table('injureds', function (Blueprint $table) {
            $table->bigInteger('health_insurance_number')->nullable()->unique()->after('injured_percentage');
            $table->date('health_insurance_start_date')->nullable()->after('health_insurance_number');
            $table->date('health_insurance_end_date')->nullable()->after('health_insurance_start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('injureds', function (Blueprint $table) {
            $table->dropColumns(['health_insurance_number', 'health_insurance_start_date', 'health_insurance_end_date']);
        });
    }
};
