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
        Schema::create('prospectings', function (Blueprint $table) {
            $table->id();
            $table->string('contacts');
            $table->string('createdBy');
            $table->string('type');
            $table->string('subject');
            $table->string('date');
            $table->text('observation')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospectings');
    }
};
