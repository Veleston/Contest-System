<?php

namespace Database\Seeders;

use App\Models\Contest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($count = 1, $types = ['NORMAL'])
    {
        $contests = [];
        
        for ($i = 0; $i < $count; $i++) {
            $type = $types[array_rand($types)];
            $contests[] = [
                'name' => "Contest " . ($i + 1),
                'description' => "Description for Contest " . ($i + 1),
                'access_level' => $type,
                'start_time' => now()->subDays(rand(0, 5)),
                'end_time' => now()->addDays(rand(1, 10)),
                'prize_amount' => rand(100, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Contest::insert($contests);
    }
}
