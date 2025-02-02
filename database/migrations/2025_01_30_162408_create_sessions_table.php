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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['مطلوب', 'منفذ']);
            $table->dateTime('date');
            $table->decimal('budget', 15, 2)->default(0);
            $table->decimal('budget_from_org', 15, 2)->nullable()->default(0);
            $table->decimal('budget_out_of_org', 15, 2)->nullable()->default(0);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('sessions');
    }
};
