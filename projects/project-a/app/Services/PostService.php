<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Application service for Post domain logic.
 * Demonstrates usage of Query Builder and Eloquent ORM.
 *
 * @category Services
 * @package  App\Services
 * @author   Your Name <example@example.com>
 * @license  MIT License
 * @link     https://example.com
 */
class PostService
{
	/**
	 * List posts using the Query Builder with optional search filter.
	 *
	 * @param array<string, mixed> $filters Filters: 'q' (string) for title search
	 *
	 * @return LengthAwarePaginator Paginator instance
	 */
	public function list(array $filters = []): LengthAwarePaginator
	{
		$query = DB::table('posts')
			->select(['id', 'title', 'published_at', 'created_at', 'updated_at'])
			->orderByDesc('created_at');

		if (!empty($filters['q'])) {
			$q = '%' . $filters['q'] . '%';
			$query->where('title', 'like', $q);
		}

		return $query->paginate(10)->withQueryString();
	}

	/**
	 * Find a post via Eloquent.
	 *
	 * @param int $id Post ID
	 *
	 * @return Post The found post or 404 thrown
	 */
	public function find(int $id): Post
	{
		return Post::findOrFail($id);
	}

	/**
	 * Create a post via Eloquent.
	 *
	 * @param array<string, mixed> $data Validated payload
	 *
	 * @return Post Newly created post
	 */
	public function create(array $data): Post
	{
		return Post::create($data);
	}

	/**
	 * Update a post via Eloquent.
	 *
	 * @param Post                 $post Target post
	 * @param array<string, mixed> $data Validated payload
	 *
	 * @return bool True on success
	 */
	public function update(Post $post, array $data): bool
	{
		return $post->update($data);
	}

	/**
	 * Delete a post via Eloquent.
	 *
	 * @param Post $post Target post
	 *
	 * @return bool|null True on success, null if soft deletes used
	 */
	public function delete(Post $post): ?bool
	{
		return $post->delete();
	}
}
