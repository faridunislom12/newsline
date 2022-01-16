<?php

namespace Database\Seeders;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\UserRequest;
use App\Http\Traits\MainTrait;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    use MainTrait;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $component_columns = [];
        $component_columns['article'] = $this->get_all_columns(new ArticleRequest());
        $component_columns['category'] = $this->get_all_columns(new CategoryRequest());
        $component_columns['user'] = $this->get_all_columns(new UserRequest());

        \App\Models\User::insert([
            'name' => 'Администратор',
            'last_name' => 'Администраторов',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'component_columns' => json_encode($component_columns),
            'is_active' => true,
        ]);

        \App\Models\User::insert([
            'name' => 'Модератор',
            'last_name' => 'Иванов',
            'email' => 'moderator@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'component_columns' => json_encode($component_columns),
            'is_active' => true,
        ]);

        \App\Models\User::insert([
            'name' => 'Пользователь',
            'last_name' => 'Рядовой',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'component_columns' => json_encode($component_columns),
            'is_active' => true,
        ]);

        $this->call(LaratrustSeeder::class);


        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1',
            'user_type' => 'App\Models\User',
        ]);

        DB::table('role_user')->insert([
            'role_id' => '2',
            'user_id' => '2',
            'user_type' => 'App\Models\User',
        ]);

        DB::table('role_user')->insert([
            'role_id' => '3',
            'user_id' => '3',
            'user_type' => 'App\Models\User',
        ]);

        Category::factory(10)->create();
        Article::factory(100)->create();

    }
}
