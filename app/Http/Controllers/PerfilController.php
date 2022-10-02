<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        // Modificar $request para evitar la duplicidad de username:
        // el "unique" no funciona con el comando "slug",
        $request->request->add([
            'username' => Str::slug($request->username),
            'email' => $request->email
        ]);

        $this->validate($request, [
            // Evitamos el error al guardar los cambios y que indique que el usuario (yo) ya lo tengo registrado.
            'username'  => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:editar-perfil']
        ]);

        if ($request->imagen) {
            // $input = $request->all();
            $imagen = $request->file('imagen');

            // Nombre único (generando UUID)
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            // Retocamos la imagen
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            // Se sube al servidor y se graba.
            $imagenPath = public_path('perfiles') . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        // Ha podido modificar su "username", por lo que no podemos cogerlo de auth().
        return redirect()->route('posts.index', $usuario->username);
    }
}
