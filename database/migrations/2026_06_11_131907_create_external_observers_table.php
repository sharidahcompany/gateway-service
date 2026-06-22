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
        Schema::create('external_observers', function (Blueprint $table) {
            $table->id();
            $table->string('from');
            $table->json('from_name');
            $table->string('to');
            $table->json('to_name');
            $table->string('status');
            $table->string('applied_by');
            $table->string('applied_by_uuid')->nullable();
            $table->string('action_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_observers');
    }
};
