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
        Schema::create('userlocations', function (Blueprint $table) {
            $table->id();
            $table->string('city')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('payment')->nullable();
            $table->string('user_id')->nullable();
            $table->string('is_active')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userlocations');
    }
};
