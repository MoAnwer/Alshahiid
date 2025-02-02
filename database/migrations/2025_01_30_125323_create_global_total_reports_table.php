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
        Schema::create('global_total_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('need')->nullable()->default(0);
            $table->bigInteger('done')->nullable()->default(0);
            $table->decimal('precentage', 3, 2)->nullable()->default(0);
            $table->bigInteger('budget')->nullable()->default(0);
            $table->bigInteger('budget_from_org')->nullable()->default(0);
            $table->bigInteger('budget_out_of_org')->nullable()->default(0);
            $table->bigInteger('totalMoney')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_total_reports');
    }
};
