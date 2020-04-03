<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('users')->truncate();

        \DB::table('users')->insert([
            'status' => '1',
            'name' => 'Dragana Maksimovic',
            'email' => 'maximovic.daca@gmail.com',
            'password' => \Hash::make('cubesphp'),
            'phone' => '0665557777',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \DB::table('users')->insert([
            'name' => 'Pera Peric',
            'email' => 'pera.peric@gmail.com',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('users')->insert([
            'name' => 'Marko Markovic',
            'email' => 'marko.markovic@gmail.com',
            'password' => \Hash::make('cubesphp'),
            'phone' => '0222434444',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('users')->insert([
            'name' => 'Maja Maja',
            'email' => 'maja.maja@gmail.com',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        \DB::table('users')->insert([
            'name' => 'Miki Mikic',
            'email' => 'miki.mikic@gmail.com',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
    
}
