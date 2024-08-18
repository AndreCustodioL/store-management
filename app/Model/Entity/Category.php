<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Category {    
    /**
     * ID da Loja que detém a categoria cadastrada
     *
     * @var int
     */
    public $id_loja;
        
    /**
     * ID da Categoria de produtos
     *
     * @var int
     */
    public $id;
        
    /**
     * Nome da categoria
     *
     * @var string
     */
    public $nome;
        
    /**
     * Situacao da categoria (1 - ativo | 0 - inativo)
     *
     * @var int
     */
    public $situacao;
    
    /**
     * Método responsável por retornar categorias atráves do id da categoria e da loja
     *
     * @param  int $id_loja
     * @param  int $id
     * @return Category
     */
    public static function getCategoryById($id_loja,$id) {
        return self::getCategories('id_loja = '.$id_loja.' AND '.'id = '.$id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar as categorias cadastradas em uma loja
     *
     * @param  int $id_loja
     * @return PDOStatement
     */
    public static function getCategoriesByShop($id_loja) {
        return self::getCategories('id_loja = '.$id_loja);
    }
    
    /**
     * Método responsável por retornar categorias
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getCategories($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('categorias'))->select($where,$order,$limit,$fields);
    }
}