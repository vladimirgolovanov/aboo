<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\PostGroupType;

class AddCollectionPostGroupType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $postGroupType = new PostGroupType;
        $postGroupType->id = 1;
        $postGroupType->name = 'Collection';
        $postGroupType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        PostGroupType::where('name', 'Collection')
                     ->where('id', 1)
                     ->delete();

        DB::statement("ALTER TABLE `post_group_types` AUTO_INCREMENT=1;");
    }
}
