<?php

namespace App\Dao;

use App\Produto;
use Illuminate\Support\Facades\DB;

class ProdutoRepository
{

    public function pesquisa($categoria = 0, $pesquisa = "")
    {

        $produtos = Array();

        $sql = "select distinct p.id as id, p.nome nome, p.foto foto
                from produto_categoria pc, produtos p, categorias c 
                where pc.produto_id = p.id and 
                      pc.categoria_id = c.id ";

        if($categoria > 0){

            $sql = $sql .  " and c.id = $categoria ";

        }

        if($pesquisa != "" ){

            $sql = $sql .  " and upper(p.nome) like upper('%$pesquisa%') ";

        }


        $result =  DB::select($sql);


        foreach($result as $r){

            $produto = new Produto();
            $produto->id = $r->id;
            $produto->nome = $r->nome;
            $produto->foto = $r->foto;


            array_push($produtos, $produto);

        }


        return $produtos;

    }

}