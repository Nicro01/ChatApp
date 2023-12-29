<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomUserPivot;

class RoomUserPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomUserPivot::create([
            'user_id' => 1,
            'room_id' => 1,
        ]);
    }
}
