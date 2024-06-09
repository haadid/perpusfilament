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

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained();
            $table->string('slug')->unique();
            $table->string('book_code');
            $table->integer('stock')->default(0);
            $table->integer('available')->default(0);
            $table->integer('borrowed')->default(0);
            $table->integer('damaged')->default(0);
            $table->integer('lost')->default(0);
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
        Schema::dropIfExists('inventories');
    }
};
