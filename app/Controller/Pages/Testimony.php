<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page{
    
    /**
     * Método responsável por obter a renderização dos itens de dpoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return void
     */
    private static function getTestimonyItems($request,&$obPagination){
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies('deletado = 0',null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //QUANTIDADE POR PÁGINA
        $qtdPagina = $queryParams['results'] ?? 5;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$qtdPagina);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies('deletado = 0','id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            //VIEW DE DEPOIMENTOS
            $itens .= View::render('pages/testimony/item', [
                'nome' => $obTestimony ->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s',strtotime($obTestimony->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
        
    }

    /**
     * Método responsável por retornar o contéudo (view) de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request){

        //VIEW DE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
            'itens' =>self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request,$obPagination)
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('André Custodio - Depoimentos',$content);
    }
    
    /**
     * Método responsável por cadastrar um depoimento
     *
     * @param  Request $request
     * @return string
     */
    public static function insertTestimony($request) {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obtestimony = new EntityTestimony;
        $obtestimony->nome = $postVars['nome'];
        $obtestimony->mensagem = $postVars['mensagem'];
        $obtestimony->cadastrar();

        //RETORNA A PAGINA DE LISTAGEM DE DEPOIMENTOS
        return self::getTestimonies($request);
    }

}