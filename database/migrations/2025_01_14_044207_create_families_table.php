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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['أرملة و ابناء' , 'أب و أم و أخوان و أخوات', 'أخوات', 'مكتفية']);
            $table->foreignId('supervisor_id')->constrained('supervisors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('martyr_id')->constrained('martyrs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('families');
    }
};
