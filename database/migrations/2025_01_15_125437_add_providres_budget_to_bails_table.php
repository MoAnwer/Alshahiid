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
        Schema::table('bails', function (Blueprint $table) {
            $table->decimal('budget_from_org', 10, 2)->nullable();
            $table->decimal('budget_out_of_org', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bails', function (Blueprint $table) {
            //
        });
    }
};
