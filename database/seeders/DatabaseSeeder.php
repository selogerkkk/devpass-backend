<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Curso;
use App\Models\Comunidade;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );

        $users = User::factory(10)->create();

        Comunidade::factory(5)->create()->each(function ($comunidade) use ($users) {
            $comunidade->membros()->attach(
                $users->random(rand(1, 5))->pluck('id')->toArray()
            );
        });

        Curso::factory()->count(5)->create();
    }
}
