<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courseNames = ['Science', 'Mathematics', 'History', 'English', 'Physics', 'Chemistry', 'Biology', 'Computer Science'];

        return [
            'name' => $this->faker->unique()->randomElement($courseNames),
            'code' => fake()->unique()->bothify('C###'),
        ];
    }
}
