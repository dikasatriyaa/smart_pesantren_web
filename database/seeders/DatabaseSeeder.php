<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Santri;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Muhamad Andika',
                'nik' => '1571012603000091',
                'email' => 'admin@gmail.com',
                'role' => '2',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Alviona Safitri',
                'nik' => '1092010398000045',
                'email' => 'alviona@gmail.com',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Ahmad Abdul Haq',
                'nik' => '',
                'email' => 'abdul@gmail.com',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Rahmawan Fitriansyah',
                'nik' => '',
                'email' => 'rahmawan@gmail.com',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Zhorif Muzani',
                'nik' => '',
                'email' => 'zhorif@gmail.com',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Abdurrahman Wahid',
                'nik' => '',
                'email' => 'wahid@gmail.com',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Zainul Arifi',
                'nik' => '',
                'email' => 'zainul@gmail.com',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Santri::factory()->count(50)->create();
        // User::factory()->count(30)->create();
        // Guru::factory()->count(5)->create();
    }
}
