<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::create(['name' => 'General Chat']);
        Chat::create(['name' => 'Tech Chat']);
        Chat::create(['name' => 'Gaming Chat']);
    }
}
