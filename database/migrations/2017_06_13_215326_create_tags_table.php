<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->integer('post_group_id')->unsigned();
            $table->timestamps();

            $table->unique(['tag_id', 'post_id']);

            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('post_group_id')->references('id')->on('post_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_tag', function (Blueprint $table) {
            $table->dropForeign('post_tag_tag_id_foreign');
            $table->dropForeign('post_tag_post_id_foreign');
            $table->dropForeign('post_tag_post_group_id_foreign');
            $table->dropUnique('post_tag_tag_id_post_id_unique');
        });
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
    }
}
