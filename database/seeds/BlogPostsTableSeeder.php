<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('blog_posts')->truncate();

        $tags = \DB::table('tags')->get();
        $tagIds = $tags->pluck('id');

        $blogPostCategoryIds = \DB::table('blog_post_categories')->get()->pluck('id');

        $userIds = \DB::table('users')->get()->pluck('id');

        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 100; $i++) {
            \DB::table('blog_posts')->insert([
                'subject' => $faker->city(),
                'body' => $faker->realtext(1500),
                'description' => $faker->realtext(500),
                'blog_post_category_id' => $blogPostCategoryIds->random(),
                'user_id' => $userIds->random(),
                'created_at' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
                'updated_at' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
                'views' => rand(0, 1024),
            ]);
        }
    }

}
