<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'skarandanis@gmail.com',
            'password' => bcrypt('7ujm&UJM'),
        ]);
        $adminRole =Role::create(['name' => 'role.admin','label'=>'Admin']);
        Role::create(['name' => 'role.editor','label'=>'Editor']);
        Role::create(['name' => 'role.user','label'=>'User']);
        $adminUser->assignRole($adminRole);

        if (! app()->environment('production')) {
            Post::factory(100)->create();
            Category::factory(5)->create();
        }
    }
}
