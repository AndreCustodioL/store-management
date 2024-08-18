<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Product {
    
    /**
     * ID da loja onde este produto está cadastrado
     *
     * @var int
     */
    public $id_loja;
    
    /**
     * ID do produto
     *
     * @var int
     */
    public $id;
    
    /**
     * UUID (Universally Unique Identifier) do produto
     *
     * @var string
     */
    public $uuid;
    
    /**
     * Nome do produto
     *
     * @var string
     */
    public $nome;
    
    /**
     * Descrição sobre o produto
     *
     * @var string
     */
    public $descricao;
    
    /**
     * ID da categoria onde o produto faz parte
     *
     * @var int
     */
    public $id_categoria;
    
    /**
     * Unidade de venda do produto
     *
     * @var string
     */
    public $un_venda;
    
    /**
     * Preço de custo do produto
     *
     * @var float
     */
    public $preco_custo;
    
    /**
     * Preço de venda do produto
     *
     * @var float
     */
    public $preco_venda;
    
    /**
     * Quantidade em estoque do produto
     *
     * @var float
     */
    public $qtd_estoque;
    
    /**
     * Data e hora de cadastro do produto
     *
     * @var string
     */
    public $data_cadastro;
    
    /**
     * Data e hora de atualização do produto
     *
     * @var string
     */
    public $data_atualizacao;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        //DEFINE A DATA
        $this->data_cadastro = $this->data_atualizacao = date('Y-m-d H:i:s');
        

        //INSERE O PRODUTO NO BANCO DE DADOS
        $this->id = (new Database('produtos'))->insert([
            'id_loja' => $this->id_loja,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'id_categoria' => $this->id_categoria,
            'un_venda' => $this->un_venda,
            'preco_custo' => $this->preco_custo,
            'preco_venda' => $this->preco_venda,
            'qtd_estoque' => $this->qtd_estoque,
            'data_cadastro' => $this->data_cadastro,
            'data_atualizacao' => $this->data_atualizacao
        ]);

        //SUCESSO
        return true;

    }

    /**
     * Método responsável por atualizar os dados do banco com a instância atual
     *
     * @return boolean
     */
    public function atualizar(){
        //DEFINE A DATA
        $this->data_atualizacao = date('Y-m-d H:i:s');

        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('produtos'))->update('uuid = "'.$this->uuid.'"',[
            'id_loja' => $this->id_loja,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'id_categoria' => $this->id_categoria,
            'un_venda' => $this->un_venda,
            'preco_custo' => $this->preco_custo,
            'preco_venda' => $this->preco_venda,
            'qtd_estoque' => $this->qtd_estoque,
            'data_cadastro' => $this->data_cadastro,
            'data_atualizacao' => $this->data_atualizacao
        ]);

    }

    /**
     * Método responsável por excluir um produto do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI O PRODUTO NO BANCO DE DADOS
        return (new Database('produtos'))->delete('id_loja = '.$this->id_loja.' AND '.'id = '.$this->id);

    }
    
    /**
     * Método responsável por retornar um produto com base no seu id e loja 
     *
     * @param  int $id
     * @return Product
     */
    public static function getProductById($id_loja,$id){
        return self::getProducts('id_loja = '.$id_loja.' AND '.'id = '.$id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar um produto com base no seu uuid 
     *
     * @param  int $id
     * @return Product
     */
    public static function getProductByUuid($uuid){
        return self::getProducts('uuid = '.'"'.$uuid.'"')->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar produtos
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getProducts($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('produtos'))->select($where,$order,$limit,$fields);
    }
}