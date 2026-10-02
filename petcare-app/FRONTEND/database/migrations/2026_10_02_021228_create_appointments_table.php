<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pet_id');
        $table->unsignedBigInteger('owner_id');
        $table->dateTime('appointment_date');
        $table->string('notes')->nullable();
        $table->timestamps();

        $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
