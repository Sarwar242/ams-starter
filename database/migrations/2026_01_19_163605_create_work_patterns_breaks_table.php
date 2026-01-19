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
        Schema::create('work_pattern_breaks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('work_pattern_id')
                ->constrained('work_patterns')
                ->onDelete('cascade');

            $table->time('break_start')->comment('Break start time');
            $table->time('break_end')->comment('Break end time');

            $table->unsignedTinyInteger('active_flag')->default(10);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_patterns_breaks');
    }
};
