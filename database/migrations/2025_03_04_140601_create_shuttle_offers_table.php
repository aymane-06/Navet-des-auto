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
        Schema::create('shuttle_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('max_subscribers');
            $table->integer('current_subscribers')->default(0);
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for search optimization
            $table->index(['departure_city', 'arrival_city']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shuttle_offers');
    }
};
