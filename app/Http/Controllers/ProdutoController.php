<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Http\Requests\ProdutoRequest;
use App\Produto;
use App\Dao\ProdutoRepository;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    private $produtoRepository = null;

    public function __construct() {
        $this->produtoRepository = new ProdutoRepository();
    }

    public function lista()
    {

        $produtos = Produto::orderBy('nome')->get();
        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos')
            ->with('produtos', $produtos)
            ->with('categorias', $categorias)
            ->with('idCategoriaPesquisa', 0)
            ->with('pesquisa', "");

    }


    public function listarest()
    {

        $produtos = Produto::orderBy('nome')->get();
        $categorias = Categoria::orderBy('nome')->get();

        $produto = Produto::with('categorias')
            ->orderBy('nome')
            ->get();

        return $produto;

    }

    public function pesquisa(Request $request)
    {

        $pesquisa = $request->input('pesquisa');
        $categoria = $request->input('categoria');

        if(strlen(trim ($pesquisa)) == 0 && $categoria == -1){

            $produtos = Produto::orderBy('nome')->get();

        }else{

            $produtos = $this->produtoRepository->pesquisa($categoria, $pesquisa);
        }

        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos')
            ->with('produtos', $produtos)
            ->with('categorias', $categorias)
            ->with('idCategoriaPesquisa', $categoria)
            ->with('pesquisa', $pesquisa);

    }

    public function novo()
    {


        $produto = new Produto();

        $categorias = Categoria::orderBy('nome')->get();
        return view('incluiproduto')
            ->with('produto', new Produto())
            ->with('categorias', $categorias)
            ->with('idsCategoriaProduto', $produto->categorias()->allRelatedIds());

    }


    public function inclui(ProdutoRequest $request)
    {

        $categorias = $request->input('categorias');
        $nome = $request->input('nome');
        $descricao = $request->input('descricao');
        $id = $request->input('id');

        $name = null;
        if ($request->hasFile('imagem')) {
            $image = $request->file('imagem');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
        }

        if ($id != null) {

            $produto = Produto::orderBy('nome')->find($id);
            $produto->categorias()->detach();

        }else{

            $produto = new Produto();

        }

        if($name != null){
            $produto->foto = '/images/' . $name;
        }
        $produto->nome = $nome;
        $produto->descricao = $descricao;
        $produto->save();

        $produto->categorias()->attach($categorias);

        return redirect('/produtos');

    }

    public function apaga(Request $request)
    {

        $id = $request->input('id');

        $produto = Produto::orderBy('nome')->find($id);

        $produto->delete();

        return redirect('/produtos');

    }

    public function edita(Request $request)
    {

        $id = $request->input('id');

        $produto = Produto::with('categorias')->find($id);

        $idsCategorias = $produto->categorias()->allRelatedIds();

        $categorias = Categoria::all();

        return view('incluiproduto')
            ->with('produto', $produto)
            ->with('categorias', $categorias)
            ->with('idsCategoriaProduto', $idsCategorias);

    }
}
