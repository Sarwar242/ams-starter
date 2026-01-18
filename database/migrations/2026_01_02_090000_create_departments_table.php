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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Department name');
            $table->text('description')->nullable()->comment('Optional description');

            // Audit fields
            $table->unsignedBigInteger('created')->nullable()->comment('Created by user ID');
            $table->unsignedBigInteger('modified')->nullable()->comment('Modified by user ID');
            $table->timestamp('deleted_at')->nullable()->comment('Deleted at (logical delete)');
            $table->unsignedBigInteger('deleted')->nullable()->comment('Deleted by user ID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
