<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'category_id' => \App\Models\Category::all()->random(),
            'text' => $this->faker->text(200),
            'publish_at' => $this->faker->dateTimeBetween('-100 days', '10 days'),
            'is_active' => $this->faker->boolean,
        ];
    }
}



