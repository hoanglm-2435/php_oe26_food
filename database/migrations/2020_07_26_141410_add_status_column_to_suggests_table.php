<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToSuggestsTable extends Migration
{
    public function up()
    {
        Schema::table('suggests', function (Blueprint $table) {
            if (!Schema::hasColumn('suggests', 'status')) {
                $table->integer('status');
            }
        });
    }

    public function down()
    {
        Schema::table('suggests', function (Blueprint $table) {
            if (Schema::hasColumn('suggests', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
