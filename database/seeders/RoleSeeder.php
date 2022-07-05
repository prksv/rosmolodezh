<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'student'
        ]);
        Role::create([
            'name' => 'tutor'
        ]);
        Role::create([
            'name' => 'manager'
        ]);
        Role::create([
            'name' => 'admin'
        ]);
    }
}
