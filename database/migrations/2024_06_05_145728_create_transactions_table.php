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

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('book_id')->constrained();
            $table->dateTime('requested_at');
            $table->dateTime('borrowed_at')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->string('status');
            $table->string('type');
            $table->text('reason')->nullable();
            $table->foreignId('original_transaction_id')->nullable()->constrained('transactions');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
