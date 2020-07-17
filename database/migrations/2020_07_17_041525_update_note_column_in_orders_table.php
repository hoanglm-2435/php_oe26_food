<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNoteColumnInOrdersTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('orders', 'note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('note')->nullable()->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orders', 'note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('note')->nullable(false)->change();
            });
        }
    }
}
