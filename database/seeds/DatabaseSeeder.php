<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UsersTableSeeder::class);
        $this->call(BlogPostCategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(BlogPostsTableSeeder::class);
        $this->call(BlogPostTagsTableSeeder::class);
        $this->call(SlidesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }

}
