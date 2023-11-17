<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function welcome(Request $request)
    {
        $page = $request->input('page', 1);

        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json($posts);
        }

        return Inertia::render('Welcome', [
            'posts' => $posts
        ]);
    }

    private function getWelcomeData($page)
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $page);
        
        return $posts;
    }

    public function create(PostRequest $request)
    {
        $file = $request->file('image');
        $user = Auth::user();

        $file_path = $file->store('public/posts/' . $user->id);
        $file_path = str_replace('public/', '', $file_path);

        Post::create([
            'user_id' => $user->id,
            'image_path' => $file_path,
            'image_name' => $file->getClientOriginalName(),
            'image_filter' => $request->input('filter'),
            'comment' => $request->input('comment')
        ]);

        $page = $request->input('page', 1);
        $posts = $this->getWelcomeData($page);

        if ($request->wantsJson()) {
            return response()->json(['posts' => $posts, 'success' => 'Post criado com sucesso!']);
        }

        return Inertia::render('Welcome', [
            'posts' => $posts,
            'success' => 'Post criado com sucesso!'
        ]);
    }

    public function user($user)
    {
        $authUser = Auth::user()->load('posts');

        if ($authUser && $authUser->user === $user) {
            $user = $authUser;
        } else {
            $user = User::where('user', $user)->with('posts')->first();

            if (!$user) {
                return;
            }
        }

        return Inertia::render('User', [
            'user' => $user
        ]);
    }
}
