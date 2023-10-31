<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
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

        $schema->create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->char('periode', 5);
            $table->char('kelas', 3);
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
        Schema::dropIfExists('kelas');
    }
}
