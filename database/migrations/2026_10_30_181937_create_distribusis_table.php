<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('menu');
            $table->unsignedInteger('jumlah_porsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
