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
        Schema::create('family_member_documents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['شهادة ميلاد', 'شهادة مدرسية', 'رقم وطني']);
            $table->string('storage_path', 500);
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
        Schema::dropIfExists('family_member_documents');
    }
};
