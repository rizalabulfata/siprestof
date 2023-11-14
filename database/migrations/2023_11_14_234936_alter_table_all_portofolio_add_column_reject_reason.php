<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAllPortofolioAddColumnRejectReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['hk_aplikom', 'hk_artikel', 'hk_buku', 'hk_desain_produk', 'hk_film', 'kompetisi', 'penghargaan', 'organisasi'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->text('reject_reason')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = ['hk_aplikom', 'hk_artikel', 'hk_buku', 'hk_desain_produk', 'hk_film', 'kompetisi', 'penghargaan', 'organisasi'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('reject_reason');
            });
        }
    }
}
