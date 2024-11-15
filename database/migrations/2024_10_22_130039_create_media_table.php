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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('media_path');
            $table->string('type');
            $table->foreignIdFor(\App\Models\Cv::class, 'cv_id')->nullable();
            $table->foreignIdFor(\App\Models\Contract::class, 'contract_id')->nullable();
            $table->foreignIdFor(\App\Models\Prospecting::class, 'prospecting_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
