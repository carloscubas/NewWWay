<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Http\Requests\CategoriaRequest;
use App\Http\Requests\PesquisaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function lista()
    {
        $categorias = Categoria::all();
        return view('categorias')->with('categorias', $categorias);

    }

    public function novo()
    {
        return view('incluicategoria')->with('categoria', new Categoria());
    }

    public function pesquisa(Request $request)
    {

        $pesquisa = $request->input('pesquisa');

        if($pesquisa != null){
            $categorias = Categoria::where('nome', $pesquisa)
                ->orWhere('nome', 'like', '%' . $pesquisa . '%')->get();
        }else{
            $categorias = Categoria::all();
        }

        return view('categorias')->with('categorias', $categorias);

    }

    public function inclui(CategoriaRequest $request)
    {

        $input = $request->all();

        $name = null;
        if ($request->hasFile('imagem')) {
            $image = $request->file('imagem');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
        }

        if (array_get($input, 'id')) {

            $categoria = Categoria::all()->find($input['id']);

            if($name != null){
                $categoria->foto = '/images/' . $name;
            }

            $categoria->nome = $input['nome'];
            $categoria->update();

        }else{

            $categoria = new Categoria();
            $categoria->foto = '/images/' . $name;
            $categoria->nome = $input['nome'];
            $categoria->save();

        }

        return redirect('/categorias');
    }

    public function apaga(Request $request)
    {
        $id = $request->input('id');

        $categoria = Categoria::all()->find($id);

        $categoria->delete();

        return redirect('/categorias');
    }

    public function edita(Request $request)
    {
        $id = $request->input('id');

        $categoria = Categoria::all()->find($id);

        return view('incluicategoria')->with('categoria', $categoria);
    }

}
