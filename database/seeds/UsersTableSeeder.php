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
            'name' => 'Felipe Bergamin',
            'email' => 'felipebergamin6@gmail.com',
            'password' => bcrypt('fe.li.pe.'),
        ]);
    }
}
