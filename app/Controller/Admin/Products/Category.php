<?php

namespace App\Controller\Admin\Products;

use \App\Model\Entity\Category as EntityCategory;
use \App\Utils\View;
use \App\Controller\Admin\Page;
use \App\Controller\Admin\Alert;
use \WilliamCosta\DatabaseManager\Pagination;
use \Ramsey\Uuid\Uuid;

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
        while($obCategory = $results->fetchObject(EntityCategory::class)){
            //VIEW DE PRODUTOS
            $itens .= View::render('admin/modules/products/groups/item', [
                'id_loja' => $obCategory ->id_loja,
                'id' => $obCategory ->id,
                'uuid' =>$obCategory->uuid,
                'nome' => $obCategory ->nome
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
     * Método responsável por retornar o formulário de cadastro de categorias
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewCategory($request){
        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/products/groups/form',[
            'title' => 'Cadastrar Grupo de Produto',
            'nome' => '',
            'status' => '',
            'button' => 'Cadastrar'
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Grupo de Produto',$content,'products');
    }
    
    /**
     * Método responsável por incluir um novo registro de categoria no banco
     *
     * @param  Request $request
     * @return string
     */
    public static function setNewCategory($request) {
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE CATEGORIA
        $obCategory = new EntityCategory();
        $obCategory->id_loja = $request->user->id_loja;
        $obCategory->uuid = Uuid::uuid4()->toString();
        $obCategory->nome = $postVars['nome'];
        $obCategory->situacao = 1;
        $obCategory->cadastrar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/products/groups/'.$obCategory->uuid.'/edit?status=created');
    }
    
    /**
     * Método responsável por retornar o formulário de edição de categorias
     *
     * @param  Request $request
     * @return string
     */
    public static function getEditCategory($request,$uuid){
        //OBTEM A CATEGORIA DO BANCO DE DADOS
        $obCategory = EntityCategory::getCategoryByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obCategory instanceof EntityCategory){
            $request->getRouter()->redirect('/admin/products/groups');
        }

        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/products/groups/form',[
            'title' => 'Editar Grupo de Produto',
            'nome' => $obCategory->nome,
            'status' => '',
            'button' => 'Editar'
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Grupo de Produto',$content,'products');
    }

    
    
    /**
     * Método responsável por editar um registro de categoria no banco
     *
     * @param  Request $request
     * @return string
     */
    public static function setEditCategory($request,$uuid) {
        $postVars = $request->getPostVars();

        //OBTEM A CATEGORIA DO BANCO DE DADOS
        $obCategory = EntityCategory::getCategoryByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obCategory instanceof EntityCategory){
            $request->getRouter()->redirect('/admin/products/group');
        }

        //NOVA INSTANCIA DE CATEGORIA
        $obCategory = new EntityCategory();
        $obCategory->id_loja = $request->user->id_loja;
        $obCategory->uuid = Uuid::uuid4()->toString();
        $obCategory->nome = $postVars['nome'];
        $obCategory->situacao = 1;
        $obCategory->cadastrar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/products/groups/'.$obCategory->uuid.'/edit?status=created');
    }

    public static function setDeleteCategory($request,$uuid){
        //OBTEM A CATEGORIA DO BANCO DE DADOS
        $obCategory = EntityCategory::getCategoryByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obCategory instanceof EntityCategory) {
            $request->getRouter()->redirect('admin/products/group');
        }

        //VALIDA SE A CATEGORIA PERTENCE A MESMA LOJA DO USUÁRIO QUE REQUISITOU
        if($obCategory->id_loja != $request->user->id_categoria) {
            $request->getRouter()->redirect('admin/products/group');
        }

        //ALTERA A SITUAÇÃO DA CATEGORIA DENTRO DO BANCO DE DADOS
        $obCategory->excluir();

        $request->getRouter()->redirect('/admin/products/groups?status=deleted');
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