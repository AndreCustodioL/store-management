<?php

namespace App\Controller\Admin\Products;

use \App\Model\Entity\UnitMeasure as EntityUnitMeasure;
use \App\Utils\View;
use \App\Controller\Admin\Page;

class UnitMeasure extends Page {
    
    /**
     * Método responsável por retornar uma unidade de medida pelo seu ID e ID da loja
     *
     * @param  int $id_loja
     * @param  int $id
     * @return UnitMeasure
     */
    public static function getUnitMeasureById($id_loja,$id){
        return EntityUnitMeasure::getUnitMeasureById($id_loja,$id);
    }
    
    /**
     * Método responsável por retornar as unidades de medida renderizadas de uma loja
     *
     * @param  int $id_loja
     * @return string
     */
    public static function getUnitMeasureItems($id_loja,$selected = '') {
        //UNIDADES DE MEDIDA
        $unidades = '';

        //RESULTADOS
        $results = EntityUnitMeasure::getUnitsByShop($id_loja);

        //RENDERIZA O ITEM
        while($obUnit = $results->fetchObject(EntityUnitMeasure::class)) {
            //VIEW DAS OPÇÕES DE CATEGORIA
            $unidades .= View::render('admin/modules/products/snippets/option-item',[
                'id' => $obUnit->id,
                'selected' => ($obUnit->id == $selected) ? 'selected' : '',
                'nome' => $obUnit->sigla.' - '.$obUnit->nome
            ]);
        }

        //RETORNA AS CATEGORIAS RENDERIZADAS
        return $unidades;
    }
}