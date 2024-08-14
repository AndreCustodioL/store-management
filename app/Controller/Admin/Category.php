<?php

namespace App\Controller\Admin;

use \App\Model\Entity\Category as EntityCategory;

class Category extends Page {

    public static function getCategoryById($id_loja,$id){
        return EntityCategory::getCategoryById($id_loja,$id);
    }
}