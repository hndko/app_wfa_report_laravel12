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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('report_date')->comment('Tanggal laporan');
            $table->time('start_time')->comment('Jam mulai kerja');
            $table->time('end_time')->comment('Jam selesai kerja');
            $table->string('work_location')->comment('Lokasi kerja WFA');
            $table->text('activities')->comment('Deskripsi kegiatan');
            $table->text('results')->nullable()->comment('Hasil kerja');
            $table->text('notes')->nullable()->comment('Catatan tambahan');
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable()->comment('Alasan penolakan');
            $table->timestamps();

            // Index untuk performa query
            $table->index(['user_id', 'report_date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
