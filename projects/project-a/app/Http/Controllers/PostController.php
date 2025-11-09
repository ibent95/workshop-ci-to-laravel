<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller for Post CRUD operations.
 * Demonstrates Dependency Injection of a domain service.
 *
 * @category Controllers
 * @package  App\Http\Controllers
 * @author   Your Name <example@example.com>
 * @license  MIT License
 * @link     https://example.com
 */
class PostController extends Controller
{
	/**
	 * Inject dependencies.
	 *
	 * @param PostService $posts Post domain service
	 */
	public function __construct(private readonly PostService $posts) {}

	/**
	 * Display a listing of posts.
	 *
	 * @param Request $request Incoming request
	 *
	 * @return View
	 */
	public function index(Request $request): View
	{
		$filters = $request->only('q');
		$items = $this->posts->list($filters);
		return view(
			'posts.index',
			[
				'posts' => $items,
				'filters' => $filters,
			]
		);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view('posts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StorePostRequest $request Validated request
	 *
	 * @return RedirectResponse
	 */
	public function store(StorePostRequest $request): RedirectResponse
	{
		$post = $this->posts->create($request->validated());
		return redirect()
			->route('posts.show', $post)
			->with('status', 'Post created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Post $post Target post
	 *
	 * @return View
	 */
	public function show(Post $post): View
	{
		return view('posts.show', compact('post'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Post $post Target post
	 *
	 * @return View
	 */
	public function edit(Post $post): View
	{
		return view('posts.edit', compact('post'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdatePostRequest $request Validated request
	 * @param Post              $post    Target post
	 *
	 * @return RedirectResponse
	 */
	public function update(UpdatePostRequest $request, Post $post): RedirectResponse
	{
		$this->posts->update($post, $request->validated());
		return redirect()
			->route('posts.show', $post)
			->with('status', 'Post updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Post $post Target post
	 *
	 * @return RedirectResponse
	 */
	public function destroy(Post $post): RedirectResponse
	{
		$this->posts->delete($post);
		return redirect()->route('posts.index')->with('status', 'Post deleted');
	}
}
