<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wyczyść cache uprawnień
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Tworzenie uprawnień
        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.create']);

        // Tworzenie ról
        $organizerRole = Role::findByName('organizer');
        $clientRole = Role::findByName('client');

        // Przypisywanie uprawnień do ról
        $organizerRole->givePermissionTo('events.index');
        $organizerRole->givePermissionTo('events.create');

        
    }
}
