<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id(); // ID untuk primary key
            $table->string('flight_code')->unique(); // Kode pesawat (unik)
            $table->string('airline_name'); // Nama maskapai
            $table->dateTime('departure_time'); // Jam terbang
            $table->dateTime('arrival_time'); // Jam sampai
            $table->integer('price'); // Harga tiket
            $table->string('from'); // Asal
            $table->string('to'); // Tujuan
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights'); // Menghapus tabel flights jika rollback
    }
}
