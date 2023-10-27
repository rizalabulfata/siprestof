<?php

use App\Helpers\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegenciesTable extends Migration
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

        $schema->create('regencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->references('id')->on('provincies')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->commonFields();
        });
        $schema->create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regency_id')->references('id')->on('regencies')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->commonFields();
        });
        $schema->create('villages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->references('id')->on('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('name');
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
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
    }
}
