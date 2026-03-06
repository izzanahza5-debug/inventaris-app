<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenjangIdToPengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            // Menambahkan kolom jenjang_id sebagai foreign key
            $table->foreignId('jenjang_id')->constrained('jenjangs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['jenjang_id']);
            $table->dropColumn('jenjang_id');
        });
    }
}
