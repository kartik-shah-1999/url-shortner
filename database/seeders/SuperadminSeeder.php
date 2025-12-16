<?php

namespace Database\Seeders;

use App\RoleEnum;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $superAdmin = User::create([
                'name' => 'Sembark Tech',
                'email' => 'sembarktech123@test.in',
                'password' => Hash::make('sembarktech')
            ]);

            UserRole::create([
                'user_id' => $superAdmin->id,
                'user_role' => RoleEnum::SUPERADMIN
            ]);
        });
    }
}
