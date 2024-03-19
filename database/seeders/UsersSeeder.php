<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => "admin@infinety.es",
        ], [
            'name' => 'admin',
            'password' => Hash::make("OldBranding10"),
        ]);

        $user->assignRole('develop');

        $user = User::firstOrCreate([
            'email' => "anselmi@infinety.es",
        ], [
            'name' => 'anselmi',
            'password' => Hash::make("OldBranding10"),
        ]);

        $user = User::firstOrCreate([
            'email' => "ismael@infinety.es",
        ], [
            'name' => 'ismael',
            'password' => Hash::make("OldBranding10"),
        ]);
    }
}
