<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan')->insert([
            [
                'name' => "11,000 - 33.3%",
                'amount' => 11000,
                'percentage' => 33.3,
                'months_term' => 6,
                'months_lockin' => 6,
                'months_cooldown' => 1,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => "23,000 - 37.8%",
                'amount' => 23000,
                'percentage' => 37.8,
                'months_term' => 6,
                'months_lockin' => 6,
                'months_cooldown' => 1,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => "55,000 - 45%",
                'amount' => 55000,
                'percentage' => 45,
                'months_term' => 6,
                'months_lockin' => 6,
                'months_cooldown' => 1,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => "315,000 - 55%",
                'amount' => 315000,
                'percentage' => 55,
                'months_term' => 6,
                'months_lockin' => 6,
                'months_cooldown' => 1,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
