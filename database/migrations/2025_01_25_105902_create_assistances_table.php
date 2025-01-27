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
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'افطار الصائم',
                'اكرامية عيد الفطر',
                'اكرامية عيد الاضحي',
                'إعانات طارئة',
                'مساعدات',
                'سفر و انتقال',
                'احتفالات',
                'راعي و رعية',
                'قوت عام',
                'زيارات المشرفين',
                'صيانة سكن',
                'إيجار',
                'رسوم سكن',
                'رسوم مشروعات',
                'تأهيل مشروعات',
                'دعم استراتيجي'
            ]);
            $table->decimal('budget', 20, 2);
            $table->decimal('budget_from_org', 20, 2)->default(0);
            $table->decimal('budget_out_of_org', 20, 2)->default(0);
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
        Schema::dropIfExists('assistances');
    }
};
