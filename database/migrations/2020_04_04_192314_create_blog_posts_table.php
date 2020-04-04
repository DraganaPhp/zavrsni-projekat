<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject', 255)->comment('post subject');
            $table->text('body', 255)->comment('text of the post');
            $table->bigInteger('tag_id');
            $table->bigInteger('blog_post_category_id');
            $table->bigInteger('user_id');
            $table->bigInteger('comment_id')->comment('comment added on this post')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('on_index_page')->default(0)->comment('if comment should be displayed on index page');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('blog_posts');
    }

}
