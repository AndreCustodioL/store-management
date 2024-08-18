<?php

namespace App\Controller\Admin;

use \App\Model\Entity\Category as EntityCategory;
use \App\Utils\View;

class Category extends Page {
    
    /**
     * Método responsável por retornar uma categoria pelo seu ID e ID da loja
     *
     * @param  int $id_loja
     * @param  int $id
     * @return Category
     */
    public static function getCategoryById($id_loja,$id){
        return EntityCategory::getCategoryById($id_loja,$id);
    }
    
    /**
     * Método responsável por retornar as categorias renderizadas de uma loja
     *
     * @param  int $id_loja
     * @return void
     */
    public static function getCategoriesItems($id_loja,$selected = '') {
        //CATEGORIAS
        $categorias = '';

        //RESULTADOS
        $results = EntityCategory::getCategoriesByShop($id_loja);

        //RENDERIZA O ITEM
        while($obCategory = $results->fetchObject(EntityCategory::class)) {
            //VIEW DAS OPÇÕES DE CATEGORIA
            $categorias .= View::render('admin/modules/products/category/item',[
                'id' => $obCategory->id,
                'selected' => ($obCategory->id == $selected) ? 'selected' : '',
                'nome' => $obCategory->nome
            ]);
        }

        //RETORNA AS CATEGORIAS RENDERIZADAS
        return $categorias;
    }
}