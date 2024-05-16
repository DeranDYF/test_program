<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin.web@gmail.com'], [
            'name' => 'Deran Deriyana F',
            'email' => 'admin.web@gmail.com',
            'password' => Hash::make('admin.web.1221'),
        ]);
    }
}
