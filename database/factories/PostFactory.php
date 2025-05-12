<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use App\Support\PostFixtures;
use App\Models\Topic;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'topic_id' => Topic::factory(),
            'title' => str($this->faker->sentence())->beforeLast('.')->title(),
            'body' => Collection::times(4, fn () => $this->faker->realText(1250))->join(PHP_EOL.PHP_EOL),
        ];
    }

    public function withFixture()
    {
        return $this->sequence(...(new PostFixtures())->getFixtures());
    }

}
