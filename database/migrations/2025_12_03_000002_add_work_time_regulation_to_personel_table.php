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
        Schema::create('personel_work_time_regulation_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personel_id')->constrained('personel')->onDelete('cascade');
            $table->foreignId('work_time_regulation_id')
                ->constrained('work_time_regulations')
                ->onDelete('restrict')
                ->name('pwtrh_wtr_id_fk');
            $table->date('valid_from');
            $table->date('valid_to')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Index dla szybkiego wyszukiwania aktualnego regulaminu
            $table->index(['personel_id', 'valid_from', 'valid_to'], 'pwtrh_search_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personel_work_time_regulation_history');
    }
};

