<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TicketCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TicketCategorySeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@ujug-ujug.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin#123'),
                'is_admin' => true,
            ]
        );
    }
}
