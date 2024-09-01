<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Organization{
    /**
    * UUID (Universally Unique Identifier) da loja
    *
    * @var string
    */
    public $uuid;

    /**
    * ID da loja
    *
    * @var int
    */
    public $id;

    /**
    * Nome/Razão social da loja
    *
    * @var string
    */
    public $nome_razao;

    /**
    * Nome fantasia da loja
    *
    * @var string
    */
    public $nome_fantasia;

    /**
    * RG ou IE da loja
    *
    * @var string
    */
    public $rg_ie;

    /**
    * CPF ou CNPJ da loja
    *
    * @var string
    */
    public $cpf_cnpj;

    /**
    * Tipo de contribuinte da loja
    *
    * @var string
    */
    public $tipo_contribuinte;

    /**
    * Data e hora de cadastro da loja
    *
    * @var string
    */
    public $data_cadastro;

    /**
    * Data e hora de modificação da loja
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
    * Logotipo da loja
    *
    * @var string
    */
    public $logotipo;

    /**
    * CEP da loja
    *
    * @var string
    */
    public $cep;

    /**
    * Logradouro da loja
    *
    * @var string
    */
    public $logradouro;

    /**
    * Situação da loja (ativo ou inativo)
    *
    * @var bool
    */
    public $situacao;

    /**
    * Cidade da loja
    *
    * @var string
    */
    public $cidade;

    /**
    * Bairro da loja
    *
    * @var string
    */
    public $bairro;

    /**
    * Estado da loja
    *
    * @var string
    */
    public $estado;

    /**
    * Número do endereço da loja
    *
    * @var string
    */
    public $numero;

    /**
    * Complemento do endereço da loja
    *
    * @var string
    */
    public $complemento;

    /**
    * Nome do responsável ou contato da loja
    *
    * @var string
    */
    public $nome;

    /**
    * Telefone da loja
    *
    * @var string
    */
    public $telefone;
    
    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->id = (new Database('loja'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'nome_razao' => $this->nome_razao,
            'nome_fantasia' => $this->nome_fantasia,
            'rg_ie' => $this->rg_ie,
            'cpf_cnpj' => $this->cpf_cnpj,
            'tipo_contribuinte' => $this->tipo_contribuinte,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
            'logotipo' => $this->logotipo,
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'situacao' => $this->situacao,
            'cidade' => $this->cidade,
            'bairro' => $this->bairro,
            'estado' => $this->estado,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
        ]);

        return true;
    }
    
    /**
     * Método responsável por atualizar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function atualizar(){
        return (new Database('loja'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'nome_razao' => $this->nome_razao,
            'nome_fantasia' => $this->nome_fantasia,
            'rg_ie' => $this->rg_ie,
            'cpf_cnpj' => $this->cpf_cnpj,
            'tipo_contribuinte' => $this->tipo_contribuinte,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
            'logotipo' => $this->logotipo,
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'situacao' => $this->situacao,
            'cidade' => $this->cidade,
            'bairro' => $this->bairro,
            'estado' => $this->estado,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
        ]);
    }

    /**
     * Método responsável por "excluir" uma loja do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI A PESSOA NO BANCO DE DADOS
        return (new Database('loja'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);
    }
    
    /**
     * Método responsável por retornar a loja baseado no seu uuid
     *
     * @param  string $uuid
     * @return Organization
     */
    public static function getOrganizationByUuid($uuid){
        return self::getOrganizations("uuid = '".$uuid."'")->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar lojas
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getOrganizations($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('loja'))->select($where,$order,$limit,$fields);
    }  
    
}