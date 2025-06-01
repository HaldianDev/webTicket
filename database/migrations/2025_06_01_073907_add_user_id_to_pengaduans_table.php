<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('pengaduans', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->after('id');

        // Tambahkan foreign key agar user_id terkait dengan users.id
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade'); // jika user dihapus, pengaduan juga dihapus
    });
}

public function down()
{
    Schema::table('pengaduans', function (Blueprint $table) {
        // Drop foreign key dulu baru kolom
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}

};
