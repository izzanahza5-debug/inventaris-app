<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaToPengajuanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_details', function (Blueprint $table) {
            $table->string('nota')->nullable(); // Menyimpan nama file/path foto nota
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_details', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
