<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function welcome(Request $request)
    {
        $page = $request->input('page', 1);

        $posts = Post::with('user')->orderBy('id')->paginate(5, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json($posts);
        }

        return Inertia::render('Welcome', [
            'posts' => $posts
        ]);
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $file = $request->file('image');
        if (!$file) {
            return;
        }

        $user = Auth::user();
        if (!$user) {
            return;
        }

        $file_path = $file->store('public/posts/' . $user->id);
        $file_path = str_replace('public/', '', $file_path);
        // dd($file_path);
        Post::create([
            'user_id' => $user->id,
            'image_path' => $file_path,
            'image_name' => $file->getClientOriginalName(),
            'image_filter' => $request->input('filter'),
            'comment' => $request->input('comment')
        ]);
    }
}
