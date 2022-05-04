<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reply;

class RepliesTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        Reply::factory()->count(1000)->create();
    }
}

