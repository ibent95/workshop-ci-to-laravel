<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for Post model.
 *
 * @category Factories
 * @package  Database\Factories
 * @author   Your Name <example@example.com>
 * @license  MIT License
 * @link     https://example.com
 * @extends  Factory<Post>
 */
class PostFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Post::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => $this->faker->sentence(),
			'body' => $this->faker->paragraphs(asText: true),
			'published_at' => $this->faker->boolean(70)
				? $this->faker->dateTimeBetween('-1 year')
				: null,
		];
	}
}
