<?php

namespace Database\Seeders;

use App\Models\AccountInteractivity;
use App\Models\Comments;
use App\Models\likes;
use App\Models\notifications;
use App\Models\Posts;
use App\Models\User;
use App\Models\UserAccount;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Posts::factory(100)->create();
        notifications::factory(10)->create();
        // Comments::factory(1000)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
