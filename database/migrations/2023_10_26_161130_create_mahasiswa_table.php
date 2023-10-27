<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('region_id')->nullable()->references('id')->on('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('nim', 20);
            $table->string('address');
            $table->string('email');
            $table->string('no_hp', 13);
            $table->enum('last_edu', ['sd', 'smp', 'sma', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']);
            $table->date('birth_date');
            $table->string('valid_date', 4);
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
        Schema::dropIfExists('mahasiswa');
    }
}
