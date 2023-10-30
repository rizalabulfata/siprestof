<?php

use App\Helpers\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKompetisiTable extends Migration
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

        $schema->create('kompetisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kodifikasi_id')->references('id')->on('kodifikasi')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->text('desc')->nullable();
            $table->enum('type', ['individu', 'tim']);
            $table->string('organizer');
            $table->char('year', 4)->nullable();
            $table->json('documentation');
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
        Schema::dropIfExists('kompetisi');
    }
}
