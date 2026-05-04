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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_bookings')->default(1);
            $table->integer('current_bookings')->default(0);
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('date');
            $table->index('status');
            $table->unique(['date', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
