<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => '道路',
                'email' => 'douro@test.com',
            ],
            [
                'name' => '災害',
                'email' => 'saigai@test.com',
            ],
            [
                'name' => '水道',
                'email' => 'suidou@test.com',
            ],
            [
                'name' => '鳥獣',
                'email' => 'tyoujuu@test.com',
            ],
        ]);
    }
}
