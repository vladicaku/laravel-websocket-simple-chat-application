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
		DB::table('users')->insert([
			'name' => 'Vladica Jovanovski',
			'email' => 'vladica.jovanovski@gmail.com',
			'password' => bcrypt('password123'),
		]);

		DB::table('users')->insert([
			'name' => 'Mladen Jovanovski',
			'email' => 'mladen.jovanovski@gmail.com',
			'password' => bcrypt('password456'),
		]);
    }
}
