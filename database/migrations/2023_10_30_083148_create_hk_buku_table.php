<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHkBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = DB::getSchemaBuilder();
        $schema->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });

        $schema->create('hk_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kodifikasi_id')->references('id')->on('kodifikasi')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('page_total')->nullable();
            $table->char('year', 4)->nullable();
            $table->json('documentation');
            $table->commonFields();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hk_buku');
    }
}
