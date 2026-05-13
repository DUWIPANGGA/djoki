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
        Schema::create('order_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');           // relative path to storage
            $table->string('file_hash')->nullable();
            $table->string('mime_type');
            $table->unsignedBigInteger('size');    // bytes
            
            // Security & access control
            $table->string('access_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->boolean('is_encrypted')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index('order_id');
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_files');
    }
};
