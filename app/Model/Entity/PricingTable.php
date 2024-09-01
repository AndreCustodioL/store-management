<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class PricingTable {
    /**
    * UUID (Universally Unique Identifier) da tabela de preço
    *
    * @var string
    */
    public $uuid;

    /**
    * ID da tabela de preço
    *
    * @var int
    */
    public $id;

    /**
    * ID da loja associada a esta tabela de preço
    *
    * @var int
    */
    public $id_loja;

    /**
    * Nome da tabela de preço
    *
    * @var string
    */
    public $nome;

    /**
    * Tipo de cálculo da tabela de preço
    *
    * @var string
    */
    public $tipo_calculo;

    /**
    * Percentual aplicado na tabela de preço
    *
    * @var double
    */
    public $percentual;

    /**
    * Situação da tabela de preço (ativo ou inativo)
    *
    * @var bool
    */
    public $situacao;

    /**
    * Data e hora de cadastro da tabela de preço
    *
    * @var string
    */
    public $data_cadastro;

    /**
    * Data e hora de modificação da tabela de preço
    *
    * @var string
    */
    public $data_modificacao;

    /**
    * ID do usuário que fez o cadastro
    *
    * @var int
    */
    public $id_usuario_cadastro;

    /**
    * ID do usuário que fez a modificação
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
        $this->id = (new Database('tabela_preco'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'tipo_calculo' => $this->tipo_calculo,
            'percentual' => $this->percentual,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
        ]);

        return true;
    }
    
    /**
     * Método responsável por atualizar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function atualizar(){
        return (new Database('tabela_preco'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'tipo_calculo' => $this->tipo_calculo,
            'percentual' => $this->percentual,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
        ]);
    }

    /**
     * Método responsável por "excluir" uma tabela de preço do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI A PESSOA NO BANCO DE DADOS
        return (new Database('tabela_preco'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);
    }
    
    /**
     * Método responsável por retornar a tabela de preço baseado no seu uuid
     *
     * @param  string $uuid
     * @return PricingTable
     */
    public static function getPricingTableByUuid($uuid){
        return self::getOrganizations("uuid = '".$uuid."'")->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar tabelas de preço
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getOrganizations($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('tabela_preco'))->select($where,$order,$limit,$fields);
    }
}