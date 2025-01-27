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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->enum('sector', ['اروما', 'حلفا', 'القاش']);
            $table->enum('locality', ['كسلا', 'خشم القربة', 'همشكوريب', 'تلكوك', 'شمال الدلتا', 'جنوب الدلتا','ريفي كسلا', 'غرب كسلا', 'ود الحليو', 'نهر عطبرة', 'ريفي غرب كسلا', 'حلفا الجديدة']);
            $table->string('neighborhood');
            $table->enum('type', ['ملك', 'مؤجر', 'حكومي', 'ورثة', 'استضافة', 'قروي', 'رحل', 'أخرى']);
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
        Schema::dropIfExists('addresses');
    }
};
