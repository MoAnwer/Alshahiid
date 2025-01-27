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
        Schema::create('bails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('budget', 10, 2)->default(0);
            $table->enum('type', ['مجتمعية', 'مؤسسية', 'المنظمة'])->default('المنظمة');
            $table->enum('provider', ['من داخل المنظمة', 'من خارج المنظمة']);
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('bails');
    }
};
