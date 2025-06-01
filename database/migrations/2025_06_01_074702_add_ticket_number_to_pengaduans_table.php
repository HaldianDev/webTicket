<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->string('ticket_number')->unique()->after('id');
        });
    }

    public function down()
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropUnique('pengaduans_ticket_number_unique'); // drop unique index dulu
            $table->dropColumn('ticket_number'); // baru drop kolom
        });
    }
};
