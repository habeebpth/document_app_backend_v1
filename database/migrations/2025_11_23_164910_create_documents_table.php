<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Date field
            $table->date('date')->nullable();

            // Category dropdown (if you use categories table)
            $table->unsignedBigInteger('category_id')->nullable();

            // Text inputs
            $table->string('subject')->nullable();
            $table->string('title')->nullable();

            // Long text editors
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();

            // File uploads
            $table->string('file_1')->nullable();
            $table->string('file_2')->nullable();

            // Status (active/inactive/draft)
            $table->enum('status', ['active','inactive'])->default('active');

            // Soft delete
            $table->softDeletes();

            $table->timestamps();

            // Foreign key (optional)
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
