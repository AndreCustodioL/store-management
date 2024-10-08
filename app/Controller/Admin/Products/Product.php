<?php

namespace App\Controller\Admin\Products;

use \App\Utils\View;
use \App\Model\Entity\Product as EntityProduct;
use \WilliamCosta\DatabaseManager\Pagination;
use Ramsey\Uuid\Uuid;
use \App\Controller\Admin\Page;
use \App\Controller\Admin\Alert;

class Product extends Page {

    /**
     * Método responsável por obter a renderização dos itens de produtos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return void
     */
    private static function getProductItems($request,&$obPagination){
        //PRODUTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityProduct::getProducts('id_loja = '.$request->user->id_loja,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //QUANTIDADE POR PÁGINA
        $qtdPagina = $queryParams['results'] ?? 5;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$qtdPagina);

        //RESULTADOS DA PÁGINA
        $results = EntityProduct::getProducts('id_loja = '.$request->user->id_loja,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obProduct = $results->fetchObject(EntityProduct::class)){
            //VIEW DE PRODUTOS
            $itens .= View::render('admin/modules/products/item', [
                'id_loja' => $obProduct ->id_loja,
                'id' => $obProduct ->id,
                'nome' => $obProduct ->nome,
                'descricao' => $obProduct->descricao,
                'id_categoria' => (Category::getCategoryById($obProduct->id_loja, $obProduct->id_categoria))->nome ?? '',
                'preco_venda' => $obProduct->preco_venda,
                'uuid' => $obProduct->uuid
                //'data' => date('d/m/Y H:i:s',strtotime($obProduct->data))
            ]);
        }

        //RETORNA OS PRODUTOS
        return $itens;
        
    }
       
    /**
     * Método responsável por renderizar a view de listagem de produtos
     *
     * @param  Request $request
     * @return string
     */
    public static function getProducts($request){
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/products/index',[
            'itens' => self::getProductItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Produtos cadastrados',$content,'products');
    }
    
    /**
     * Método responsável por retornar o formulário de cadastro de um novo produto
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewProduct($request){
        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/products/form',[
            'title' => 'Cadastrar Produto',
            'nome' => '',
            'descricao' => '',
            'categorias' => Category::getOptionCategoriesItems($request->user->id_loja),
            'unidades_compra' => UnitMeasure::getUnitMeasureItems($request->user->id_loja),
            'unidades_venda' => UnitMeasure::getUnitMeasureItems($request->user->id_loja),
            'preco_custo' => '',
            'preco_venda' => '',
            'qtd_estoque' => '',
            'status' => ''
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Produto',$content,'products');
    }
    
    /**
     * Método responsável por cadastrar um produto no banco
     * @param  Request $request
     * @return string
     */
    public static function setNewProduct($request){
        //POST VARS
        $postVars = $request->getPostVars();
        
        //NOVA INSTANCIA DE PRODUTO
        $obProduct = new EntityProduct;

        //ATRIBUI PROPRIEDADES QUE NÃO VEM DO POSTVARS
        $obProduct->id_loja = $request->user->id_loja;
        $obProduct->uuid = Uuid::uuid4()->toString();

        //MAPEIA E PREENCHE OS ATRIBUTOS DA INSTANCIA DE PRODUTOS COM AS VARIAVEIS DO POST
        foreach ($postVars as $key => $value) {
            if (property_exists($obProduct, $key)) {
                $obProduct->$key = $value;
            }
        }
        $obProduct->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/products/'.$obProduct->uuid.'/edit?status=created');
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
                return Alert::getSuccess('Produto criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Produto atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Produto excluido com sucesso');
                break;
        }

    }
    
    /**
     * Método responsável por retornar o formulário de edição de um produto
     *
     * @param  Request $request
     * @param int $uuid
     * @return string
     */
    public static function getEditProduct($request,$uuid){

        //OBTEM O PRODUTO DO BANCO DE DADOS
        $obProduct = EntityProduct::getProductByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obProduct instanceof EntityProduct){
            $request->getRouter()->redirect('/admin/products');
        }

        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/products/form',[
            'title' => 'Editar Produto',
            'nome' => $obProduct->nome,
            'descricao' => $obProduct->descricao,
            'categorias' => Category::getOptionCategoriesItems($request->user->id_loja,$obProduct->id_categoria),
            'unidades_compra' => UnitMeasure::getUnitMeasureItems($request->user->id_loja,$obProduct->id_un_compra),
            'unidades_venda' => UnitMeasure::getUnitMeasureItems($request->user->id_loja,$obProduct->id_un_venda),
            'preco_custo' => $obProduct->preco_compra,
            'preco_venda' => $obProduct->preco_venda,
            'qtd_estoque' => $obProduct->qtd_estoque,
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Produto',$content,'products');
    }
    
    /**
     * Método responsável por gravar a atualização de um produto
     *
     * @param  Request $request
     * @param int $id
     * @return string
     */
    public static function setEditProduct($request,$uuid){

        //OBTEM O PRODUTO DO BANCO DE DADOS
        $obProduct = EntityProduct::getProductByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obProduct instanceof EntityProduct){
            $request->getRouter()->redirect('/admin/products');
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //MAPEIA E PREENCHE OS ATRIBUTOS DA INSTANCIA DE PRODUTOS COM AS VARIAVEIS DO POST
        foreach ($postVars as $key => $value) {
            if (property_exists($obProduct, $key)) {
                $obProduct->$key = $value;
            }
        }
        $obProduct->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/products/'.$obProduct->uuid.'/edit?status=updated');
    }
    
    /**
     * Método responsável por excluir um produto do banco de dados através do seu ID
     *
     * @param  Request $request
     * @param  string $uuid
     */
    public static function setDeleteProduct($request,$uuid) {
        //OBTEM O PRODUTO DO BANCO DE DADOS
        $obProduct = EntityProduct::getProductByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obProduct instanceof EntityProduct) {
            $request->getRouter()->redirect('/admin/products');
        }

        //VALIDA SE O PRODUTO PERTENCE AO USUÁRIO LOGADO
        if($request->user->id_loja != $obProduct->id_loja) {
            $request->getRouter()->redirect('/admin/products');
        }

        //EXCLUI O PRODUTO
        $obProduct->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/products?status=deleted');
        
    }
}