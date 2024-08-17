<?php

namespace App\Utils;

use \App\Model\Entity\User as EntityUser;

class Auth {

    public static function getUser(){
        if(!isset($_SESSION['admin']['usuario'])) {
            return null;
        }
        return EntityUser::getUserById($_SESSION['admin']['usuario']['id']);
    }
}