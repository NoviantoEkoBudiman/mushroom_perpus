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
        Schema::create('borrowed_book', function (Blueprint $table) {
            $table->id();
            
            // $table->unsignedBigInteger('book_id');
            // $table->unsignedBigInteger('murid_id');
            // $table->unsignedBigInteger('staff_id');
            // $table->foreign('book_id')->references('id')->on('book');
            // $table->foreign('murid_id')->references('id')->on('user');
            // $table->foreign('staff_id')->references('id')->on('user');

            $table->integer('book_id')->length(20);
            $table->integer('murid_id')->length(20);
            $table->integer('staff_id')->length(20);

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status_pinjam',[0,1])->comment('0 = belum dikembalikan, 1 sudah dikembalikan')->default(0);
            $table->integer('jumlah_denda')->comment('Diisi jika telat mengembalikan dalam waktu seminggu, dengan besaran Rp. 200 perhari')->nullable();
            $table->enum('status_denda',[0,1])->comment('0 = belum lunas, 1 sudah lunas')->nullable();

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
        Schema::dropIfExists('borrowed_book');
    }
};
