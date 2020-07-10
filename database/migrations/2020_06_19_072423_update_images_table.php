<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('images', 'image'))
        {
            Schema::table('images', function (Blueprint $table)
            {
                $table->dropColumn('image');
            });
        }
        if (!Schema::hasColumns('images', ['product_id', 'image_path']))
        {
            Schema::table('images', function (Blueprint $table)
            {
                $table->integer('product_id');
                $table->string('image_path');
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
        if (!Schema::hasColumn('images', 'image'))
        {
            Schema::table('images', function (Blueprint $table)
            {
                $table->binary('image');
            });
        }
        if (Schema::hasColumns('images', ['product_id', 'image_path']))
        {
            Schema::table('images', function (Blueprint $table)
            {
                $table->dropColumn('product_id');
                $table->dropColumn('image_path');
            });
        }
    }
}
