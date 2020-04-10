<?php

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('slides')->truncate();

        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 10; $i++) {
            \DB::table('slides')->insert([
                'subject' => $faker->city(),
                'on_index_page' => rand(0,1),
                'link_title' => $faker->city(),
                'link_url' => $faker->url(),
                'created_at' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
            ]);
        }
    }

}
