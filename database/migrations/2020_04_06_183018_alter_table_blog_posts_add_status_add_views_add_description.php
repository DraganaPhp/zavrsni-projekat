<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBlogPostsAddStatusAddViewsAddDescription extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('blog_posts', function (Blueprint $table) {

            $table->text('description', 500)->comment('short description of the post')->after('subject');
            $table->bigInteger('status')->default(1)->comment('if the post should be displayed')->after('photo');
            $table->bigInteger('views')->default(0)->after('on_index_page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('description');
            $table->dropColumn('views');
        });
    }

}
