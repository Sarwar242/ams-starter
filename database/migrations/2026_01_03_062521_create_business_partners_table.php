<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('business_partners', function (Blueprint $table) {
            $table->id();

            // Basic partner info
            $table->string('name')->comment('Business partner name');
            $table->string('code')->nullable()->unique()->comment('Optional partner code');

            // Flags
            $table->boolean('is_subcontractor')
                  ->default(true)
                  ->comment('Can be used for subcontract expenses');

            // Contact info (optional but practical)
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Audit + logical delete (as per client rule)
            $table->unsignedBigInteger('created')->nullable()->comment('Created by user ID');
            $table->unsignedBigInteger('modified')->nullable()->comment('Modified by user ID');
            $table->timestamp('deleted_at')->nullable()->comment('Logical delete date');
            $table->unsignedBigInteger('deleted')->nullable()->comment('Deleted by user ID');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_partners');
    }
};
