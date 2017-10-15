<?php

use App\User;
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
        factory(User::class)->create([
            'name'  => 'Jayonta Sarkar',
            'email' => 'jayonta.aiub@gmail.com'
        ]);
        factory(User::class, 3)->create();
    }
}
