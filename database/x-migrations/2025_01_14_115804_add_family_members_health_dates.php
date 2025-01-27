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
        Schema::table('family_members', function(Blueprint $table) {
            $table->date('health_insurance_start_date');
            $table->date('health_insurance_end_date');
        });
    }
};
