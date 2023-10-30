<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaUnitTable extends Migration
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

        $schema->create('mahasiswa_unit', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_id')->references('id')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
            $table->char('periode', 5);
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
        Schema::dropIfExists('mahasiswa_unit');
    }
}
