<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA DE LISTAGEM DE PRODUTOS
$obRouter->get('/admin/products',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Products\Product::getProducts($request));
    }
]);

//ROTA DE CADASTRO DE UM PRODUTO
$obRouter->get('/admin/products/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Products\Product::getNewProduct($request));
    }
]);

//ROTA DE CADASTRO DE UM PRODUTO (POST)
$obRouter->post('/admin/products/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Products\Product::setNewProduct($request));
    }
]);

//ROTA DE EDIÇÃO DE UM PRODUTO
$obRouter->get('/admin/products/{uuid}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$uuid){
        return new Response(200,Admin\Products\Product::getEditProduct($request,$uuid));
    }
]);

//ROTA DE EDIÇÃO DE UM PRODUTO (POST)
$obRouter->post('/admin/products/{uuid}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$uuid){
        return new Response(200,Admin\Products\Product::setEditProduct($request,$uuid));
    }
]);

//ROTA DE EXCLUSÃO DE UM PRODUTO
$obRouter->get('/admin/products/{uuid}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$uuid){
        return new Response(200,Admin\Products\Product::setDeleteProduct($request,$uuid));
    }
]);



//////////////////////////

//ROTA DE LISTAGEM DE GRUPOS CADASTRADOS
$obRouter->get('/admin/products/groups',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Products\Category::getCategories($request));
    }
]);