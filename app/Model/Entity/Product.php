<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Product {
    
    /**
     * UUID (Universally Unique Identifier) do produto
     *
     * @var string
     */
    public $uuid;

    /**
     * ID do produto
     *
     * @var int
     */
    public $id;
    
    /**
     * ID da loja onde este produto está cadastrado
     *
     * @var int
     */
    public $id_loja;
    
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
     * ID da Unidade de compra do produto
     *
     * @var int
     */
    public $id_un_compra;
    
    /**
     * ID da Unidade de venda do produto
     *
     * @var int
     */
    public $id_un_venda;
    
    /**
     * Fator de conversão do produto (UN Compra x UN Venda)
     *
     * @var double
     */
    public $fator_conversao;
    
    /**
     * Preço de custo do produto
     *
     * @var double
     */
    public $preco_compra;
    
    /**
     * Markup do preço de venda
     *
     * @var double
     */
    public $markup_preco_venda;
    
    /**
     * Preço de venda do produto
     *
     * @var double
     */
    public $preco_venda;
    
    /**
     * Quantidade em estoque do produto
     *
     * @var double
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
    public $data_modificacao;
    
    /**
     * ID do fornecedor do produto
     *
     * @var int
     */
    public $id_fornecedor;
    
    /**
     * ID do tipo do produto
     *
     * @var int
     */
    public $tipo_produto;
    
    /**
     * NCM do produto
     *
     * @var string
     */
    public $ncm;
    
    /**
     * CST ICMS do produto
     *
     * @var string
     */
    public $cst_icms;
    
    /**
     * Origem fiscal do produto
     *
     * @var string
     */
    public $origem_produto;
    
    /**
     * CEST do produto
     *
     * @var string
     */
    public $cest;
    
    /**
     * Imagem Principal do produto
     *
     * @var string
     */
    public $imagem_principal;
    
    /**
     * Situacao (ativo ou inativo) do produto
     *
     * @var boolean
     */
    public $situacao;
    
    /**
     * UUID do usuário em que fez a modificação
     *
     * @var mixed
     */
    public $id_usuario_modificacao;
    
    /**
     * UUID do usuário em que fez o cadastro
     *
     * @var string
     */
    public $id_usuario_cadastro;
    
    /**
     * Método responsável por calcular o markup do produto
     *
     * @param  double $preco_compra
     * @param  double $preco_venda
     * @return double
     */
    private function calcularMarkup($preco_compra,$preco_venda){
        if($preco_compra == 0) return 0;
        return (($preco_venda - $preco_compra) / $preco_compra) * 100;
    }

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        //DEFINE A DATA
        $this->data_cadastro = $this->data_modificacao = date('Y-m-d H:i:s');
        $this->markup_preco_venda = $this->calcularMarkup($this->preco_compra,$this->preco_venda);
        

        //INSERE O PRODUTO NO BANCO DE DADOS
        $this->id = (new Database('produtos'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'id_categoria' => $this->id_categoria,
            'id_un_compra' => $this->id_un_compra,
            'id_un_venda' => $this->id_un_venda,
            'fator_conversao' => $this->fator_conversao,
            'preco_compra' => $this->preco_compra,
            'markup_preco_venda' => $this->markup_preco_venda,
            'preco_venda' => $this->preco_venda,
            'qtd_estoque' => $this->qtd_estoque,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_fornecedor' => $this->id_fornecedor,
            'tipo_produto' => $this->tipo_produto,
            'ncm' => $this->ncm,
            'cst_icms' => $this->cst_icms,
            'origem_produto' => $this->origem_produto,
            'cest' => $this->cest,
            'imagem_principal' => $this->imagem_principal,
            'situacao' => $this->situacao,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
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
        $this->data_modificacao = date('Y-m-d H:i:s');

        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('produtos'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'id_categoria' => $this->id_categoria,
            'id_un_compra' => $this->id_un_compra,
            'id_un_venda' => $this->id_un_venda,
            'fator_conversao' => $this->fator_conversao,
            'preco_compra' => $this->preco_compra,
            'markup_preco_venda' => $this->markup_preco_venda,
            'preco_venda' => $this->preco_venda,
            'qtd_estoque' => $this->qtd_estoque,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_fornecedor' => $this->id_fornecedor,
            'tipo_produto' => $this->tipo_produto,
            'ncm' => $this->ncm,
            'cst_icms' => $this->cst_icms,
            'origem_produto' => $this->origem_produto,
            'cest' => $this->cest,
            'imagem_principal' => $this->imagem_principal,
            'situacao' => $this->situacao,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,

        ]);

    }

    /**
     * Método responsável por "excluir" um produto do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI O PRODUTO NO BANCO DE DADOS
        return (new Database('produtos'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);

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
     * @param  string $uuid
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