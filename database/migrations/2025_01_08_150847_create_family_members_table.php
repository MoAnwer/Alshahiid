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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->enum('gender', ['ذكر', 'أنثى']);
            $table->integer('age');
            $table->enum('relation', ['اب', 'ام', 'اخ', 'اخت', 'زوجة', 'ابن', 'ابنة']);
            $table->bigInteger('national_number');
            $table->string('phone_number')->nullable();
            $table->string('personal_image')->nullable();
            $table->bigInteger('health_insurance_number')->unique()->nullable();
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
        Schema::dropIfExists('family_members');
    }
};
