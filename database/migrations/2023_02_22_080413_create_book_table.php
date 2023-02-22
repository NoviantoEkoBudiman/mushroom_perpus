<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->string('title')->length(25);
            $table->text('description');
            $table->string('penerbit')->length(25);
            $table->string('penulis')->length(25);
            $table->unsignedBigInteger('bookshelf_id');
            $table->foreign('bookshelf_id')->references('id')->on('bookshelf');
            $table->enum('status',[0,1])->comment('0 = dipinjam, 1 = tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book');
    }
};
