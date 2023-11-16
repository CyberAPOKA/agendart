<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function welcome()
    {
        $canLogin = Route::has('login');
        $canRegister = Route::has('register');
        $posts = Post::all();

        return Inertia::render('Welcome', [
            'canLogin' => $canLogin,
            'canRegister' => $canRegister,
            'posts' => $posts
        ]);
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $file = $request->file('image');
        if (!$file) {
            // abort(400, 'Nenhum arquivo enviado.');
            return;
        }

        $user = Auth::user();
        if (!$user) {
            // abort(403, 'Nenhum usuário logado.');
            return;
        }

        $file_path = $file->store('public/posts/' . $user->id);
        $file_path = str_replace('public/', '', $file_path);
        // dd($file_path);
        Post::create([
            'image_path' => $file_path,
            'image_name' => $file->getClientOriginalName(),
            'comment' => 'teste'
        ]);
    }
}
