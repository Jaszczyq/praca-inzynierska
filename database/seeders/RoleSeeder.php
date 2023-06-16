<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Tworzenie roli organizatora
        Role::create([
            'name' => 'organizer',
        ]);

        // Tworzenie roli klienta
        Role::create([
            'name' => 'client',
        ]);

        // Dodatkowy kod seedera
    }
}
