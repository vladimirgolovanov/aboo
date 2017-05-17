<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_group_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('post_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('post_group_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('post_group_type_id')->references('id')->on('post_group_types');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_group_id')->unsigned();
            $table->text('text')->nullable();
            $table->text('text_parsed')->nullable();
            $table->timestamps();

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
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_post_group_id_foreign');
        });
        Schema::dropIfExists('posts');

        Schema::table('post_groups', function (Blueprint $table) {
            $table->dropForeign('post_groups_user_id_foreign');
            $table->dropForeign('post_groups_post_group_type_id_foreign');
        });
        Schema::dropIfExists('post_groups');

        Schema::dropIfExists('post_group_types');
    }
}
