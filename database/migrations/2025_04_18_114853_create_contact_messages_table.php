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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['unread', 'read', 'archived', 'deleted'])->default('unread');
            $table->timestamps();

            // Index for created_at (used in ordering and date filtering)
            $table->index('created_at');
            
            // Index for status (used in filtering)
            $table->index('status');
            
            // Composite index for search fields
            $table->index(['name', 'email', 'subject']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
