<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class PostController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {

        // Obtenesmos, tras enlazar ambos modelos, los posts del usuario.
        // $posts = Post::where('user_id', $user->id)->get();
        // Igual pero con paginación.
        $posts = Post::where('user_id', $user->id)->paginate(2);
        // Otro tipo de paginación.
        // $posts = Post::where('user_id', $user->id)->simplePaginate(2);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo'        => 'required|max:255',
            'descripcion'   => 'required',
            'imagen'        => 'required'
        ]);

        Post::create([
            'titulo'        => $request->titulo,
            'descripcion'   => $request->descripcion,
            'imagen'        => $request->imagen,
            'user_id'       => auth()->user()->id
        ]);

        // Otra forma de crear registros.
        // - Forma 1:
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // - Forma 2: Ya con relaciones
        // $request->user()->posts()->create([
        //     'titulo'        => $request->titulo,
        //     'descripcion'   => $request->descripcion,
        //     'imagen'        => $request->imagen,
        //     'user_id'       => auth()->user()->id
        // ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
