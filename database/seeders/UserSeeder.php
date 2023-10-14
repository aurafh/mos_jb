<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'superadmin',
            'role' => 'superadmin'
        ]);

        User::create([
            'name' => 'sales',
            'role' => 'sales',
        ]);

        User::create([
            'name' => 'purchase',
            'role' => 'purchase',
        ]);
        
        User::create([
            'name' => 'manager',
            'role' => 'manager',
        ]);
    }
}
