<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Category {    

    /**
     * UUID da categoria
     *
     * @var mixed
     */
    public $uuid;

    /**
     * ID da Categoria de produtos
     *
     * @var int
     */
    public $id;

    /**
     * ID da Loja que detém a categoria cadastrada
     *
     * @var int
     */
    public $id_loja;
              
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
     * Data e hora em que a categoria foi cadastrada
     *
     * @var string
     */
    public $data_cadastro;

    /**
     * Data e hora em que a categoria foi alterada
     *
     * @var string
     */
    public $data_modificacao;
  
    /**
     * ID do usuário que modificou o registro
     *
     * @var string
     */
    public $id_usuario_modificacao;
  
    /**
     * ID do usuário que cadastrou o registro
     *
     * @var string
     */
    public $id_usuario_cadastro;
    
    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->id = (new Database('categorias'))->insert([
            'uuid' => $this->uuid,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
        ]);

        return true;
    }
    
    /**
     * Método responsável por atualizar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function atualizar(){
        return (new Database('categorias'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
        ]);
    }

    /**
     * Método responsável por "excluir" uma categoria do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI A CATEGORIA NO BANCO DE DADOS
        return (new Database('categorias'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);
    }
    
    /**
     * Método responsável por retornar categorias através do id da categoria e da loja
     *
     * @param  int $id_loja
     * @param  int $id
     * @return Category
     */
    public static function getCategoryById($id_loja,$id) {
        return self::getCategories('id_loja = '.$id_loja.' AND '.'id = '.$id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar categorias através do uuid da categoria
     *
     * @param  string $uuid
     * @return Category
     */
    public static function getCategoryByUuid($uuid) {
        return self::getCategories('uuid = "'.$uuid.'"')->fetchObject(self::class);
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