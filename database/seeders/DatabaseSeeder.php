<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comunidade;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        $users = User::factory(10)->create();

        Comunidade::factory(5)->create()->each(function ($comunidade) use ($users) {
            $comunidade->membros()->attach(
                $users->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
