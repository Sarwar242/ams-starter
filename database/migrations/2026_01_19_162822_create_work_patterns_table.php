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
        Schema::create('work_patterns', function (Blueprint $table) {
            $table->id();

            // Company relation
            $table->foreignId('company_id')
                ->constrained('companies')
                ->comment('Company');

            // Basic info
            $table->string('name')->comment('Work pattern name (e.g. Full-time)');
            $table->string('code')->nullable()->comment('Optional code');

            // Working time
            $table->time('start_time')->comment('Work start time');
            $table->time('end_time')->comment('Work end time');

            // Overtime rules
            $table->unsignedSmallInteger('overtime_start_minutes')
                ->nullable()
                ->comment('Overtime start time in minutes from midnight');

            // Holiday rules
            $table->boolean('work_on_holiday')->default(false)->comment('Allow work on holidays');
            $table->boolean('work_on_weekend')->default(false)->comment('Allow work on weekends');

            // Night work (optional)
            $table->time('night_start')->nullable()->comment('Night work start time');
            $table->time('night_end')->nullable()->comment('Night work end time');

            // Status
            $table->boolean('is_active')->default(true);

            // Audit
            $table->unsignedBigInteger('created')->nullable();
            $table->unsignedBigInteger('modified')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_patterns');
    }
};
