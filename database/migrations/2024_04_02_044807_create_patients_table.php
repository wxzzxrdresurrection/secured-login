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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('last_name', 60);
            $table->enum('gender', ['M', 'F']);
            $table->unsignedBigInteger('insurance_id')->nullable();
            $table->timestamps();

            $table->foreign('insurance_id')->references('id')->on('insurances')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
