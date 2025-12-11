<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 28; $i++) {
            Voter::create([
                'number' => $i,
                'name'   => 'ناخب رقم ' . $i,
                'votes'  => 0,
            ]);
        }
    }
}
