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
        Schema::create('injured_services', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->enum('status', ['منفذ', 'مطلوب'])->default('مطلوب');			
			$table->enum('type', 
			[
				'إعانة عامة',
				'سكن',
				'مشروع إنتاجي',
				'طرف صناعي',
				'وسيلة حركة',
				'علاج',
				'تأهيل مهني و معنوي'
			]);
			$table->text('description')->nullable();
			$table->decimal('budget', 15, 2)->default(0);
			$table->decimal('budget_from_org', 15, 2)->default(0);
			$table->decimal('budget_out_of_org', 15, 2)->default(0);
			$table->text('notes')->nullable();
			$table->foreignId('injured_id')->constrained('injureds')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('injured_services');
    }
};
