<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('comments')->truncate();

        $blogPostIds = \DB::table('blog_posts')->get()->pluck('id');
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 100; $i++) {
            \DB::table('comments')->insert([
                'subject' => $faker->city(),
                'body' => $faker->realtext(200),
                'blog_post_id' => $blogPostIds->random(),
                'sender_email' => $faker->email(),
                'sender_nickname' => $faker->firstName(),
                'created_at' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
            ]);
        }
    }

}
