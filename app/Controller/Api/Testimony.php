<?php

namespace App\Controller\Api;

use \App\Model\Entity\Testimony as EntityTestimony;
use Exception;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api{

    /**
     * Método responsável por obter a renderização dos itens de dpoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return void
     */
    private static function getTestimonyItems($request,&$obPagination){
        //DEPOIMENTOS
        $itens = [];

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
            //DEPOIMENTOS
            $itens[] = [
                'id' => (int)$obTestimony ->id,
                'nome' => $obTestimony ->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => $obTestimony->data
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
        
    }
    
    /**
     * Método responsável por retornar os depoimentos cadastrados
     *
     * @param  Request $request
     * @return array
     */
    public static function getTestimonies($request){
        return [
            'depoimentos' => self::getTestimonyItems($request,$obPagination),
            'paginacao'   => parent::getPagination($request,$obPagination)
        ];
    }
    
    /**
     * Método responsável por retornar os detalhes de um depoimentp
     *
     * @param  Request $request
     * @param  int $id
     * @return array
     */
    public static function getTestimony($request,$id){
        //VALIDA O ID DO DEPOIMENTO
        if(!is_numeric($id)){
            throw new \Exception("O id '".$id."' Não é válido",400);
        }


        //BUSCA DEPOIMENTO
        $obTestimony = EntityTestimony::getTestimonyByid($id);

        //VALIDA SE O DEPOIMENTO EXISTE
        if(!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O Depoimento ".$id." Não foi encontrado",404);
        }

        //RETORNA OS DETALHES DO DEPOIMENTO
        return [
            'id' => (int)$obTestimony ->id,
            'nome' => $obTestimony ->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }
    
    /**
     * Método responsável por cadastrar um novo depoimento
     *
     * @param  Request $request
     * @return array
     */
    public static function setNewTestimony($request){
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if(!isset($postVars['nome']) or !isset($postVars['mensagem'])){
            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios",400);
        }

        //NOVO DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        //RETORNA OS DETALHES DO DEPOIMENTO CADASTRADO
        return [
            'id' => (int)$obTestimony ->id,
            'nome' => $obTestimony ->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }
    
    /**
     * Método responsável por atualizar um depoimento
     *
     * @param  Request $request
     * @param  int $int
     * @return array
     */
    public static function setEditTestimony($request,$id){
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if(!isset($postVars['nome']) or !isset($postVars['mensagem'])){
            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios",400);
        }

        //BUSCA O DEPOIMENTO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyByid($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O Depoimento ".$id." Não foi encontrado",404);
        }

        //ATUALIZA O DEPOIMENTO
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->atualizar();

        //RETORNA OS DETALHES DO DEPOIMENTO ATUALIZADO
        return [
            'id' => (int)$obTestimony ->id,
            'nome' => $obTestimony ->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }
    
    /**
     * Método responsável por excluir um depoimento
     *
     * @param  Request $request
     * @param  int $int
     * @return array
     */
    public static function setDeleteTestimony($request,$id){
        //BUSCA O DEPOIMENTO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyByid($id);

        //VALIDA A INSTANCIA
        if(!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O Depoimento ".$id." Não foi encontrado",404);
        }

        //EXCLUI O DEPOIMENTO
        $obTestimony->excluir();

        //RETORNA O SUCESSO DA EXCLUSAO
        return [
            'sucesso' => 'true'
        ];
    }

}