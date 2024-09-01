<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page {
 
    /**
     * Método responsável por obter a renderização dos itens de usuários para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return void
     */
    private static function getUserItems($request,&$obPagination){
        //USUÁRIOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityUser::getUsers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //QUANTIDADE POR PÁGINA
        $qtdPagina = $queryParams['results'] ?? 5;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$qtdPagina);

        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obUser = $results->fetchObject(EntityUser::class)){
            //VIEW DE DEPOIMENTOS
            $itens .= View::render('admin/modules/users/item', [
                'uuid' => $obUser ->uuid,
                'id' => $obUser->id,
                'id_loja' => $obUser->id_loja,
                'nome' => $obUser ->nome,
                'email' => $obUser->email
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
        
    }
       
    /**
     * Método responsável por renderizar a view de listagem de usuários
     *
     * @param  Request $request
     * @return string
     */
    public static function getUsers($request){
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/users/index',[
            'itens' => self::getUserItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Admin Usuários',$content,'users');
    }
    
    /**
     * Método responsável por retornar o formulário de cadastro de um novo usuário
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewUser($request){
        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/users/form',[
            'title' => 'Cadastrar Usuário',
            'id_loja' => '',
            'nome' => '',
            'email' => '',
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Usuário',$content,'users');
    }
    
    /**
     * Método responsável por cadastrar um usuário no banco
     * @param  Request $request
     * @return string
     */
    public static function setNewuser($request){
        //POST VARS
        $postVars = $request->getPostVars();
        $id_loja = $postVars['id_loja'] ?? '';
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //VALIDA O E-MAIL DO USUÁRIO
        $obUser = EntityUser::getUserByEmail($email);
        if($obUser instanceof EntityUser){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }
        
        //NOVA INSTANCIA DE USUARIO
        $obUser = new EntityUser;
        $obUser->id_loja = $id_loja;
        $obUser->nome = $nome;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha,PASSWORD_DEFAULT);
        $obUser->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=created');
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
                return Alert::getSuccess('Usuário criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluido com sucesso');
                break;
            case 'duplicated':
                return Alert::getError('O e-mail digitado já está sendo utilizado por outro usuário!');
                break;
        }

    }
    
    /**
     * Método responsável por retornar o formulário de edição de um usuário
     *
     * @param Request $request
     * @param string $uuid
     * @return string
     */
    public static function getEditUser($request,$uuid){

        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/users/form',[
            'title' => 'Editar Usuário',
            'id_loja' => $obUser->id_loja,
            'nome' => $obUser->nome,
            'email' => $obUser->email,
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Admin Editar Usuário',$content,'users');
    }
    
    /**
     * Método responsável por gravar a atualização de um usuário
     *
     * @param  Request $request
     * @param int $id
     * @return string
     */
    public static function setEditUser($request,$uuid){

        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        //POST VARS
        $postVars = $request->getPostVars();
        $id_loja = $postVars['id_loja'] ?? '';
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //VALIDA O E-MAIL DO USUÁRIO
        $obUserEmail = EntityUser::getUserByEmail($email);
        if($obUserEmail instanceof EntityUser && $obUserEmail->uuid != $uuid){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/'.$uuid.'/edit?status=duplicated');
        }

        //ATUALIZA A INSTÂNCIA
        $obUser->id_loja = $id_loja;
        $obUser->nome = $nome;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha,PASSWORD_DEFAULT);
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$obUser->uuid.'/edit?status=updated');
    }
    
    /**
     * Método responsável por retornar o formulário de exclusão de um usuário
     *
     * @param  Request $request
     * @param int $id
     * @return string
     */
    public static function getDeleteUser($request,$uuid){

        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULARIO
        $content = View::render('admin/modules/users/delete',[
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Admin Excluir Usuário',$content,'users');
    }
    
    /**
     * Método responsável por excluir um usuário
     *
     * @param  Request $request
     * @param int $id
     * @return string
     */
    public static function setDeleteUser($request,$uuid){

        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserByUuid($uuid);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        //EXCLUI O USUÁRIO
        $obUser->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users?status=deleted');
    }

}