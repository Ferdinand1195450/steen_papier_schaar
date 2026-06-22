<?php

namespace Database\Seeders;

use App\Models\Zet;
use Illuminate\Database\Seeder;

class ZetSeeder extends Seeder
{
    public function run(): void
    {
        Zet::create(['naam' => 'steen']);
        Zet::create(['naam' => 'papier']);
        Zet::create(['naam' => 'schaar']);
    }
}