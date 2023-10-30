<?php

use App\Helpers\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKodifikasiTable extends Migration
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

        $schema->create('kodifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('second_name')->nullable();
            $table->integer('skor')->default(0);
            $table->enum('kategori', ['internasional', 'regional', 'nasional', 'provinsi', 'kabupaten']);
            $table->enum('bidang', ['kompetisi', 'penghargaan', 'karya', 'org_ket', 'org_waket', 'org_sekret', 'org_benda', 'org_gp', 'org_member']);
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
        Schema::dropIfExists('kodifikasi');
    }
}
