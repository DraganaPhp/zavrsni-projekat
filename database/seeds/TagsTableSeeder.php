<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('tags')->truncate();
        $tagNames = ['Fashion', 'Sport', 'Economy', 'Techmology', 'Business'];

        foreach ($tagNames as $tagName) {
            \DB::table('tags')->insert([
                'name' => $tagName,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ]);
        }
    }

}
