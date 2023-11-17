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
        //retorna a página welcome com a paginação (5 em 5) e em ordem descrecente pela data.

        $page = $request->input('page', 1);

        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $page);

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
        //faz a criação de posts de acordo com os dados vindo do request e retorna uma mensagem flash com os posts atualizados.
        $file = $request->file('image');
        $user = Auth::user();

        //remove o 'public' para salvar no banco
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

    public function posts(Request $request)
    {
        //busca novos posts quando o usuário scrollar a página no final.
        $page = $request->input('page', 1);

        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json($posts);
        }
    }
}
