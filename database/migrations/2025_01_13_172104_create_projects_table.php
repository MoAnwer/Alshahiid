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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->enum('project_type', ['فردي', 'جماعي'])->default('جماعي');
            $table->enum('status', ['يعمل', 'لا يعمل'])->default('لا يعمل');
            $table->decimal('budget', 10, 2);
            $table->string('manager_name');
            $table->text('notes')->nullable();
            $table->foreignId('family_id')->constrained('families');
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
        Schema::dropIfExists('projects');
    }
};
