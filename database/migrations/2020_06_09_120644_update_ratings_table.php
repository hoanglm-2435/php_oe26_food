<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('ratings', 'content'))
        {
            Schema::table('ratings', function (Blueprint $table)
            {
                $table->dropColumn('content');
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
        if (!Schema::hasColumn('ratings', 'content'))
        {
            Schema::table('ratings', function (Blueprint $table)
            {
                $table->text('content');
            });
        }
    }
}
