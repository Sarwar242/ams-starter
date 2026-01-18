<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Employee basic info
            $table->string('employee_code')->nullable()->unique()->after('email');

            $table->foreignId('department_id')
                  ->nullable()
                  ->after('employee_code')
                  ->constrained('departments')
                  ->nullOnDelete();

            $table->foreignId('work_pattern_id')->nullable()->after('department_id');

            // Role & status
            $table->enum('role', ['admin', 'leader', 'user'])->default('user')->after('work_pattern_id');
            $table->boolean('is_active')->default(true)->after('role');
            $table->date('joined_at')->nullable()->after('is_active');

            // Audit fields
            $table->unsignedBigInteger('created')->nullable()->comment('Created user ID')->after('created_at');
            $table->unsignedBigInteger('modified')->nullable()->comment('Modified user ID')->after('updated_at');

            // Logical delete
            $table->timestamp('deleted_at')->nullable()->comment('Deleted date')->after('modified');
            $table->unsignedBigInteger('deleted')->nullable()->comment('Deleted user ID')->after('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn([
                'employee_code',
                'department_id',
                'work_pattern_id',
                'role',
                'is_active',
                'joined_at',
                'created',
                'modified',
                'deleted_at',
                'deleted',
            ]);
        });
    }
};
