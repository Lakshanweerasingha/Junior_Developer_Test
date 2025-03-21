<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Assign tasks to random users
        $users = User::all();

        foreach ($users as $user) {
            // Create 3 tasks for each user
            foreach (range(1, 3) as $index) {
                Task::create([
                    'title' => $faker->sentence,
                    'description' => $faker->paragraph,
                    // Use capitalized values to match the enum values ('Pending', 'Completed')
                    'status' => $faker->randomElement(['Pending', 'Completed']),
                    'due_date' => $faker->dateTimeBetween('now', '+1 month'),
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
