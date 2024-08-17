<?php

namespace App\Controller\Api;

use \App\Model\Entity\Category as EntityCategory;

class ProductCategory extends Api {

    public static function getCategoriesByStore($request){
        $itens = [];

        //ID DA LOJA
        $queryParams = $request->getQueryParams();

        //RESULTADOS DA PÁGINA
        $results = EntityCategory::getCategories('id_loja = '.$queryParams['id_loja'].' AND '.'situacao = 1','id DESC');

        //RENDERIZA O ITEM
        while($obCategory = $results->fetchObject(EntityCategory::class)){
            //CATEGORIAS
            $itens[] = [
                'id_loja' => (int)$obCategory ->id_loja,
                'id' => (int)$obCategory ->id,
                'nome' => $obCategory ->nome
            ];
        }

        //RETORNA AS CATEGORIAS
        return $itens;
    }
}