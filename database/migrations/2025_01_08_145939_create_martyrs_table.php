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
        Schema::create('martyrs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('marital_status', ['أعزب', 'متزوج', 'مطلق', 'منفصل']);
            // $table->integer('age');
            $table->enum('rank', ['جندي', 'جندي أول', 'عريف', 'وكيل عريف', 'رقيب', 'رقيب أول', 'مساعد', 'مساعد أول', 'ملازم', 'ملازم أول', 'نقيب', 'رائد', 'مقدم', 'عقيد', 'عميد', 'لواء', 'فريق', 'فريق أول', 'مشير']);
            $table->enum('force', ['امن', 'شرطة', 'قوات مسلحة', 'أخرى']);
            $table->string('unit');
            $table->integer('militarism_number'); // النمرة العسكرية
            $table->integer('record_number')->unique();
            $table->date('record_date');
            // $table->date('date_of_appointment')->nullable();
            $table->date('martyrdom_date');
            $table->string('martyrdom_place');
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
        Schema::dropIfExists('martyrs');
    }
};
