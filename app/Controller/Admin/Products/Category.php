<?php

namespace App\Controller\Admin\Products;

use \App\Model\Entity\Category as EntityCategory;
use \App\Utils\View;
use \App\Controller\Admin\Page;
use \App\Controller\Admin\Alert;
use \App\Model\Entity\Group as EntityGroup;
use \WilliamCosta\DatabaseManager\Pagination;

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
     * Método responsável por retornar as opções de categorias renderizadas de uma loja
     *
     * @param  int $id_loja
     * @return void
     */
    public static function getOptionCategoriesItems($id_loja,$selected = '') {
        //CATEGORIAS
        $categorias = '';

        //RESULTADOS
        $results = EntityCategory::getCategoriesByShop($id_loja);

        //RENDERIZA O ITEM
        while($obCategory = $results->fetchObject(EntityCategory::class)) {
            //VIEW DAS OPÇÕES DE CATEGORIA
            $categorias .= View::render('admin/modules/products/snippets/option-item',[
                'id' => $obCategory->id,
                'selected' => ($obCategory->id == $selected) ? 'selected' : '',
                'nome' => $obCategory->nome
            ]);
        }

        //RETORNA AS CATEGORIAS RENDERIZADAS
        return $categorias;
    }
    /**
     * Método responsável por obter a renderização dos itens de categorias de produtos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getCategoriesItems($request,&$obPagination){
        //PRODUTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityCategory::getCategories('id_loja = '.$request->user->id_loja,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //QUANTIDADE POR PÁGINA
        $qtdPagina = $queryParams['results'] ?? 5;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$qtdPagina);

        //RESULTADOS DA PÁGINA
        $results = EntityCategory::getCategories('id_loja = '.$request->user->id_loja,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obGroup = $results->fetchObject(EntityCategory::class)){
            //VIEW DE PRODUTOS
            $itens .= View::render('admin/modules/products/groups/item', [
                'id_loja' => $obGroup ->id_loja,
                'id' => $obGroup ->id,
                'nome' => $obGroup ->nome
            ]);
        }

        //RETORNA OS PRODUTOS
        return $itens;
        
    }
       
    /**
     * Método responsável por renderizar a view de listagem de categorias de produtos
     *
     * @param  Request $request
     * @return string
     */
    public static function getCategories($request){
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/products/groups/index',[
            'itens' => self::getCategoriesItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Grupo de Produtos',$content,'products');
    }

    /**
     * Método responsável por retornar a mensagem de status
     *
     * @param  Request $request
     * @return void
     */
    private static function getStatus($request) {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();
        
        //STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Grupo criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Grupo atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Grupo excluido com sucesso');
                break;
        }

    }
}