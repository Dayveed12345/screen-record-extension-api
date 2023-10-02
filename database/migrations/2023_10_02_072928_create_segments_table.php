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
        Schema::create('segments', function (Blueprint $table) {
            $table->id()->nullable();
           $table->unsignedBigInteger('transcripts_id')->references('id')->on('transcripts')->onDelete('cascade')->nullable();
           $table->string('start')->nullable();
           $table->string('end')->nullable();
           $table->text('text')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
