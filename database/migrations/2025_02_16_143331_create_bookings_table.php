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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('places_id')->constrained('places')->onDelete('cascade');
            $table->date('scheduled_date');
            $table->integer('number_of_guests')->default(1);
            $table->decimal('total_price',10,2)->nullable();
            $table->enum('status', ['pending','confirmed','cancelled'])->default('pending');
            $table->text('special_request')->nullable();
            $table->enum('payment_status', ['unpaid','paid', 'failed'])->default('unpaid');
            $table->string('payment_id')->nullable();
            $table->timestamps();
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
