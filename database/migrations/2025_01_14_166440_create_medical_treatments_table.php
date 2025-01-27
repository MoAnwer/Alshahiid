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
        Schema::create('medical_treatments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['التأمين صحي', 'علاج خارج المظلة', 'علاج بالخارج']);
            $table->enum('status', ['مطلوب', 'منفذ'])->default('مطلوب');
            $table->enum('provider', ['من داخل المنظمة', 'من خارج المنظمة']);
            $table->text('notes')->nullable();
            $table->foreignId('family_member_id')->constrained('family_members');
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
        Schema::dropIfExists('medical_treatments');
    }
};
