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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 20);
            $table->string('email');
            $table->text('address');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights');
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('taxes', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['user_id', 'status']);
            $table->index(['room_id', 'check_in', 'check_out']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
