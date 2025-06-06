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
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("book_id");
            $table->foreign("book_id")->references("id")->on("books")->onDelete("cascade");

            $table->string("file_name");
            $table->string("path");
            $table->string("url");
            $table->unsignedBigInteger("size");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
