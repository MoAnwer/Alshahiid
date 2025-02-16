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
        Schema::table('injureds', function (Blueprint $table) {
           $table->enum('sector', ['القطاع الشرقي', 'القطاع الغربي', 'القطاع الشمالي']);
           $table->enum('locality', ['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','حلفا الجديدة']);
        });
    }

};
