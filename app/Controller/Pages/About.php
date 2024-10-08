<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class About extends Page{

    /**
     * Método responsável por retornar o contéudo (view) da nossa página sobre
     * @return string
     */
    public static function getAbout(){
        //ORGANIZACAO
        $obOrganization = new Organization;

        //VIEW DA HOME
        $content = View::render('pages/about', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('André Custodio - Sobre',$content);
    }

}