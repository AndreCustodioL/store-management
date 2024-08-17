<?php

use \App\Http\Response;
use \App\Controller\Api;

//ROTA DE LISTAGEM DE CATEGORIAS CADASTRADAS NA LOJA
$obRouter->get('/api/v1/products/categories',[
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request){
        return new Response(200,Api\ProductCategory::getCategoriesByStore($request),'application/json');
    }
]);