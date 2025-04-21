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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('message')->nullable();
            $table->string('plan');
            $table->enum('status', ['new', 'contacted', 'qualified', 'converted', 'rejected', 'lost'])->default('new');
            $table->string('source')->default('website');
            $table->text('note')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('timezone')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();

            // Index for created_at (used in ordering and date filtering)
            $table->index('created_at');
            
            // Index for status (used in filtering)
            $table->index('status');
            
            // Index for plan (used in filtering)
            $table->index('plan');
            
            // Composite index for search fields
            $table->index(['name', 'email', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
