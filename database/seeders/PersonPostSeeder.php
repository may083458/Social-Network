<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PersonPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        App\Models\PagePost::create([
            'user_id' => 1,
            'follower_id' => 2,
        ]);
        App\Models\PagePost::create([
            'user_id' => 1,
            'follower_id' => 3,
        ]);
    }
}
