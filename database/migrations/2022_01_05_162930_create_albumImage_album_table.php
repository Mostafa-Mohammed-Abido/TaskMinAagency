<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albumImage_album', function (Blueprint $table) {
            $table->integer('albumImage_id')->unsigned();
            $table->integer('album_id')->unsigned();

            $table->primary(['albumImage_id', 'album_id']);
            $table->foreign('albumImage_id')->references('id')->on('albumImage_id')->onDelete('cascade');
            $table->foreign('album_id')->references('id')->on('album_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AlbumImagesTable');
    }
}
