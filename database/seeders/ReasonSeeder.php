<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reasons')->insert([
            ['name' => '報告重複'],
            ['name' => '確認できない'],
            ['name' => 'いたずら'],
        ]);
    }
} 
