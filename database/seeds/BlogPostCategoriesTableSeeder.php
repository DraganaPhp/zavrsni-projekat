<?php

use Illuminate\Database\Seeder;

class BlogPostCategoriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('blog_post_categories')->truncate();
        $blogPostCategoryNames = ['Growth', 'Local', 'Sales', 'Tips', 'Enviroment'];

        foreach ($blogPostCategoryNames as $blogPostCategoryName) {
            \DB::table('blog_post_categories')->insert([
                'name' => $blogPostCategoryName,
                'description' => 'Short description of category ' . $blogPostCategoryName,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ]);
        }
    }

}
