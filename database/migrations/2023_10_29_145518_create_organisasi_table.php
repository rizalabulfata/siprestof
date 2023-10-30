<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrganisasiTable extends Migration
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

        $schema->create('organisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kodifikasi_id')->references('id')->on('kodifikasi')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->char('year_start', 4);
            $table->char('year_end', 4);
            $table->string('sk_number');
            $table->json('certificate');
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
        Schema::dropIfExists('organisasi');
    }
}
