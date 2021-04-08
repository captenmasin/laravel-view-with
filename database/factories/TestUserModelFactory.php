<?php

namespace Captenmasin\LaravelViewWith\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Captenmasin\LaravelViewWith\Tests\Support\TestUserModel;

class TestUserModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestUserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->name,
            'email' => $this->faker->unique()->email,
        ];
    }
}
