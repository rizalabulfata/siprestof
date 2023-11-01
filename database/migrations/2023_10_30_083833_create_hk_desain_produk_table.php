<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHkDesainProdukTable extends Migration
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

        $schema->create('hk_desain_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kodifikasi_id')->references('id')->on('kodifikasi')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('bentuk_desain');
            $table->char('year', 4)->nullable();
            $table->json('mockup');
            $table->enum('approval_status', ['pending', 'approve', 'reject'])->default('pending');
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
        Schema::dropIfExists('hk_desain_produk');
    }
}
