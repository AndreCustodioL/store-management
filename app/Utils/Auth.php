<?php

namespace App\Utils;

use \App\Model\Entity\User as EntityUser;

class Auth {
    
    /**
     * Método responsável por buscar e retornar detalhes do usuário atualmente logado
     *
     * @return User
     */
    public static function getUser(){
        if(!isset($_SESSION['admin']['usuario'])) {
            return null;
        }

        return EntityUser::getUserById($_SESSION['admin']['usuario']['id']);
    }
    
}