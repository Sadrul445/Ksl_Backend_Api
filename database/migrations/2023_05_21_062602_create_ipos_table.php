<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ipos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('cutt_off_date');
            $table->string('minimum_application_amount');
            $table->string('total_share');
            $table->decimal('eps');
            $table->decimal('nav');
            $table->integer('rate');
            $table->string('type');
            $table->enum('status',['upcoming_ipo','closed_ipo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipos');
    }
};
