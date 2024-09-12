<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['name' => '受付前'],
            ['name' => '受付'],
            ['name' => '対応中'],
            ['name' => '対応済み'],
            ['name' => '非対応'],
        ]);
    }
} 
