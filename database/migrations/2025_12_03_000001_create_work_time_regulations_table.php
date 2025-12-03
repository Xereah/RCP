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
        Schema::create('work_time_regulations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nazwa regulaminu
            $table->string('code')->unique(); // Kod regulaminu (np. FULL_TIME, HALF_TIME)
            $table->text('description')->nullable(); // Opis
            $table->decimal('daily_hours', 4, 2)->default(8.00); // Godziny dziennie
            $table->decimal('weekly_hours', 4, 2)->default(40.00); // Godziny tygodniowo
            $table->decimal('monthly_hours', 5, 2)->nullable(); // Godziny miesięcznie (opcjonalnie)
            $table->boolean('is_task_based')->default(false); // Czy zadaniowy czas pracy
            $table->integer('break_minutes')->default(15); // Przerwa w pracy (min)
            $table->integer('nursing_mother_break')->default(0); // Przerwa dla matki karmiącej (min)
            $table->integer('start_time_flex')->default(0); // Elastyczność godziny rozpoczęcia (min)
            $table->integer('end_time_flex')->default(0); // Elastyczność godziny zakończenia (min)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_time_regulations');
    }
};

