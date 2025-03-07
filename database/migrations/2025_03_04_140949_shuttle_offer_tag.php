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
        Schema::create('shuttle_offer_tag', function (Blueprint $table) {
            $table->foreignId('shuttle_offer_id')->constrained();
            $table->foreignId('tag_id')->constrained();
            $table->primary(['shuttle_offer_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
