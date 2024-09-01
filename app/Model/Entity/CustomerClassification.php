<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class CustomerClassification {

    /**
    * UUID (Universally Unique Identifier) da classificação
    *
    * @var string
    */
    public $uuid;

    /**
    * ID da classificação
    *
    * @var int
    */
    public $id;

    /**
    * ID da loja onde esta classificação está cadastrada
    *
    * @var int
    */
    public $id_loja;

    /**
    * Nome da classificação
    *
    * @var string
    */
    public $nome;

    /**
    * Regra de limite da classificação
    *
    * @var string
    */
    public $regra_limite;

    /**
    * Situação da classificação (ativo ou inativo)
    *
    * @var bool
    */
    public $situacao;

    /**
    * Data e hora de cadastro da classificação
    *
    * @var string
    */
    public $data_cadastro;

    /**
    * Data e hora de modificação da classificação
    *
    * @var string
    */
    public $data_modificacao;

    /**
    * UUID do usuário que fez o cadastro
    *
    * @var int
    */
    public $id_usuario_cadastro;

    /**
    * UUID do usuário que fez a modificação
    *
    * @var int
    */
    public $id_usuario_modificacao;
    
    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->id = (new Database('classificacao_cliente'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'regra_limite' => $this->regra_limite,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
        ]);

        return true;
    }

    /**
     * Método responsável por "excluir" uma classificação do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI A CLASSIFICACAO NO BANCO DE DADOS
        return (new Database('classificacao_cliente'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);
    }
    
    /**
     * Método responsável por atualizar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function atualizar(){
        return (new Database('classificacao_cliente'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'regra_limite' => $this->regra_limite,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
        ]);
    }

    /**
     * Método responsável por retornar a classificação de cliente através do uuid
     *
     * @param  string $uuid
     * @return CustomerClassification
     */
    public static function getClassificationByUuid($uuid) {
        return self::getCustomerClassifications('uuid = "'.$uuid.'"')->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar as classificações cadastradas em uma loja
     *
     * @param  int $id_loja
     * @return PDOStatement
     */
    public static function getClassificationsByShop($id_loja) {
        return self::getCustomerClassifications('id_loja = '.$id_loja);
    }
    
    /**
     * Método responsável por retornar as classificações de clientes
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getCustomerClassifications($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('categorias'))->select($where,$order,$limit,$fields);
    }
}