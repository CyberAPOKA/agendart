<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $userIds = User::pluck('id')->all();

        foreach (range(1, 50) as $index) {

            $userId = $faker->randomElement($userIds);
            $imageNumber = rand(1, 10);
            DB::table('posts')->insert([
                'user_id' => $userId,
                'comment' => $faker->text(200),
                'image_Path' => "posts/seeder/{$imageNumber}.png",
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }
    }
}
