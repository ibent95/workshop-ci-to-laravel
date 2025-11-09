<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature tests for Post CRUD endpoints.
 *
 * @category Tests
 * @package  Tests\Feature
 * @author   Your Name <example@example.com>
 * @license  MIT License
 * @link     https://example.com
 */
class PostCrudTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * Ensure index displays posts list.
	 *
	 * @return void
	 */
	public function testItListsPosts(): void
	{
		Post::factory()->count(3)->create();

		$response = $this->get('/posts');
		$response->assertStatus(200);
		$response->assertSee(Post::first()->title);
	}

	/**
	 * Ensure creating a post persists data.
	 *
	 * @return void
	 */
	public function testItCreatesAPost(): void
	{
		$payload = [
			'title' => 'New Title',
			'body' => 'Body text',
			'published_at' => now()->format('Y-m-d\TH:i'),
		];

		$response = $this->post('/posts', $payload);
		$response->assertRedirect();
		$this->assertDatabaseHas(
			'posts',
			[
				'title' => 'New Title',
			]
		);
	}

	/**
	 * Ensure updating a post changes attributes.
	 *
	 * @return void
	 */
	public function testItUpdatesAPost(): void
	{
		$post = Post::factory()->create();
		$response = $this->put(
			"/posts/{$post->id}",
			[
				'title' => 'Updated',
				'body' => $post->body,
				'published_at' => $post->published_at?->format('Y-m-d\\TH:i'),
			]
		);
		$response->assertRedirect();
		$this->assertDatabaseHas(
			'posts',
			[
				'id' => $post->id,
				'title' => 'Updated',
			]
		);
	}

	/**
	 * Ensure deleting a post removes it from the database.
	 *
	 * @return void
	 */
	public function testItDeletesAPost(): void
	{
		$post = Post::factory()->create();
		$response = $this->delete("/posts/{$post->id}");
		$response->assertRedirect('/posts');
		$this->assertDatabaseMissing(
			'posts',
			[
				'id' => $post->id,
			]
		);
	}
}
