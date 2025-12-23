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
        Schema::create('report_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->string('file_name')->comment('Nama file asli');
            $table->string('file_path')->comment('Path penyimpanan');
            $table->string('file_type', 50)->comment('Tipe file');
            $table->integer('file_size')->comment('Ukuran file (bytes)');
            $table->string('description')->nullable()->comment('Deskripsi lampiran');
            $table->timestamps();

            $table->index('report_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_attachments');
    }
};
