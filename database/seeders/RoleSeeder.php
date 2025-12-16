<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Role::upsert(
            [
                ['id' => 1, 'role' => 'superadmin'],
                ['id' => 2, 'role' => 'admin'],
                ['id' => 3, 'role' => 'member'],
            ],
            ['id'],     
            ['role']    
        );
    }
}
