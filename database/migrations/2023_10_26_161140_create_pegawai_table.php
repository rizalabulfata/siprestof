<?php

use App\Helpers\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
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

        $schema->create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('region_id')->nullable()->references('id')->on('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
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
        Schema::dropIfExists('pegawai');
    }
}
