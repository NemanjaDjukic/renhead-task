<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'type' => $this->faker->randomElement(['BUYER','APPROVER']),
            'password' => '$2y$10$6ycID4xhu09fqgOpNNYOdOfEMrpJKvVn7aLF8lRjVipcI7jMeNSju', // 123456
        ];
    }

}
