<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\PostGroupType;

class AddWishlistPostGroupType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $postGroupType = new PostGroupType;
        $postGroupType->id = 2;
        $postGroupType->name = 'Wishlist';
        $postGroupType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        PostGroupType::where('name', 'Wishlist')
                     ->where('id', 2)
                     ->delete();

        DB::statement("ALTER TABLE `post_group_types` AUTO_INCREMENT=2;");
    }
}
