<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePost;
use App\Http\Requests\UpdatedPost;
use App\Models\Post;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    public function __construct(
        protected CommonService $commonService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Successfully accessed PostController@index');
        $data = Post::get();

        return view('posts.index', [
            'data' => $data,
            'commonService' => $this->commonService,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        $response = [];

        try {
            $data = $request->all();
            if (empty($data->published_at)) {
                throw new \Exception("Error Processing Request", 400);
            }

            Post::create($data);

            $response['success'] = true;

            Log::info('Successfully created a new post.');
        } catch (\Exception $th) {
            $response['error'] = $th->getMessage();
            Log::error('Error creating a new post: ', [
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);
        }

        return redirect()->route('posts.index')->with('response', $response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $data = Post::where('id', $id)->first();

        return view('posts.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedPost $request)
    {
        $response = [];
        try {
            $data = $request->validated();
            $post = Post::where('id', $data['id'])->first();

            if (!$post) {
                throw new \Exception("Post not found", 404);
            }

            $post->update($data);

            $response['success'] = true;
        } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
        }

        return redirect()->route('posts.index')->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
