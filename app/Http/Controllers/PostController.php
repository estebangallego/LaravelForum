<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ResourceAuthorization;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Register the resource authorization middleware for index and show.
     *
     * @return void
     */
    public function __construct()
    {
        // This middleware will check if the user has the necessary permissions to access the index and show actions.
        // You can also add ->only(['index', 'show']) to limit the actions that the middleware will check.
        $this->middleware(ResourceAuthorization::class.':'.Post::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(?Topic $topic = null)
    {
        $posts = Post::with(['user', 'topic'])
            ->when($topic, fn ($query) => $query->whereBelongsTo($topic))
            ->latest()
            ->latest('id')
            ->paginate();

        return inertia('Posts/Index', [
            'posts' => PostResource::collection($posts),
            'topics' => fn () => TopicResource::collection(Topic::all()),
            'selectedTopic' => fn () => $topic ? TopicResource::make($topic) : null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Gate::authorize('create', Post::class);
        return inertia('Posts/Create', [
            'topics' => fn () => TopicResource::collection(Topic::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'body' => ['required', 'string', 'max:5000', 'min:10'],
            'topic_id' => ['required', 'exists:topics,id'],
        ]);

        $post = Post::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect($post->showRoute())->banner('Post created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user, Post $post)
    {
        if (! Str::endsWith($post->showRoute(), request()->path())) {
            return redirect($post->showRoute($request->query()), status: 301);
        }

        $post->load('user', 'topic');

        return inertia('Posts/Show', [
            'post' => fn () => PostResource::make($post),
            'comments' => fn () => CommentResource::collection($post->comments()->with('user')->latest()->latest('id')->paginate(10)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
