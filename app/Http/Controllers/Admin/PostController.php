<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();

        return view('admin.posts.index', compact('posts')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.posts.create', compact('users')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|min:10|max:80',
            'asunto' => 'required|string|min:3|max:80',
            'contenido' => 'required|string|min:3|max:200',
        ]);

        // Asigna automáticamente el ID del usuario autenticado
        $data['user_id'] = auth()->id();

        // Guarda correctamente el post
        $post = Post::create($data);

        Evento::create([
            'titulo' => 'Nuevo Post publicado',
            'descripcion' => 'Se registró un post de "' . $post->user->name . '" en el sistema.',
            'tipo' => 'success',
            'modelo' => 'Post',
            'modelo_id' => $post->id,
            'user_id' => Auth::id(),
            ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Perfecto!',
            'string' => 'Se ha publicado un nuevo post con éxito',
        ]);

        return redirect()->route('admin.posts.index');
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
    public function edit(Post $post)
{
    $user = auth()->user();

    if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
        abort(403, 'No tienes permiso para editar este post.');
    }

    $users = User::all();

    return view('admin.posts.edit', compact('post', 'users')); 
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $user = auth()->user();

        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        $data = $request->validate([
            'titulo' => 'required|string|min:10|max:80',
            'asunto' => 'required|string|min:3|max:80',
            'contenido' => 'required|string|min:3|max:200',
        ]);

        $post->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Post Actualizado!',
            'string' => 'Se ha editado el post con éxito'
        ]);

        return redirect()->route('admin.posts.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
{
    try {
        $user = auth()->user();

        // Solo puede eliminar si es autor del post o si tiene el rol 'admin'
        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403, 'No tienes permiso para eliminar este post.');
        }

        $post->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡ Eliminado!',
            'text' => 'Se ha eliminado el post con éxito.'
        ]);

        Evento::create([
            'titulo' => 'Se ha eliminado un Post',
            'descripcion' => 'Se elimino el post de "' . $post->titulo . '" en el sistema.',
            'tipo' => 'error',
            'modelo' => 'Post',
            'modelo_id' => $post->id,
            'user_id' => Auth::id(),
            ]);

    } catch (\Throwable $e) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Error',
            'text' => 'Ocurrió un error al eliminar el post. Intenta nuevamente.'
        ]);
    }

    return redirect()->route('admin.posts.index');
}

}
