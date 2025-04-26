<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'business_owner', 'tour_guide', 'tourism_employee'];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            User::firstOrCreate(
                ['email' => "{$roleName}@example.com"],
                [
                    'name' => ucfirst($roleName),
                    'password' => Hash::make('password'),
                    'role_id' => $role->id, // ✅ Required field
                    'is_active' => true,
                ]
            );
        }
    }
}
