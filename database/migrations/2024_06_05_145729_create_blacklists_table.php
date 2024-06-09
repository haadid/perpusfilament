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
        Schema::disableForeignKeyConstraints();

        Schema::create('blacklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('reason');
            $table->boolean('is_active')->default(true);
            $table->dateTime('blacklisted_at');
            $table->dateTime('unblacklisted_at')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklists');
    }
};
