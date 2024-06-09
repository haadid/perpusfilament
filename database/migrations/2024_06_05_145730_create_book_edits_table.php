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

        Schema::create('book_edits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained();
            $table->string('title');
            $table->string('isbn')->nullable();
            $table->integer('year');
            $table->string('slug');
            $table->text('description');
            $table->string('cover')->nullable();
            $table->text('genres')->nullable();
            $table->text('categories')->nullable();
            $table->text('authors')->nullable();
            $table->text('publishers')->nullable();
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
        Schema::dropIfExists('book_edits');
    }
};
