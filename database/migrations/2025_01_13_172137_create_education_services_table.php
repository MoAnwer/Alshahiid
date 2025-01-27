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
        Schema::create('education_services', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['زي و أدوات', 'رسوم دراسية', 'تأهيل مهني', 'تأهيل نسوي', 'تكريم متفوقين', 'دراسات عليا', 'إعانات طلاب', 'دورات رفع المستويات']);
			$table->enum('status', ['مطلوب', 'منفذ'])->default('مطلوب');
			$table->decimal('budget', 15, 2)->default(0);
			$table->decimal('budget_from_org', 15, 2)->default(0);
			$table->decimal('budget_out_of_org', 15, 2)->default(0);
			$table->enum('provider', ['من داخل المنظمة', 'من خارج المنظمة'])->default('من داخل المنظمة');
            $table->foreignId('student_id')->constrained('students');
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
        Schema::dropIfExists('education_services');
    }
};
