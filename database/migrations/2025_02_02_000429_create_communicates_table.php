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
        Schema::create('communicates', function (Blueprint $table) {
            $table->id();
            $table->enum('isCom', ['تم', 'لم يتم']);
            $table->enum('status', ['مطلوب', 'منفذ']);
            $table->decimal('budget', 15, 2);
            $table->decimal('budget_from_org', 15, 2)->default(0);
            $table->decimal('budget_out_of_org', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('communicates');
    }
};
