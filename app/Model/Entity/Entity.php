<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Entity {
    /**
    * UUID (Universally Unique Identifier) da pessoa
    *
    * @var string
    */
    public $uuid;

    /**
    * ID da pessoa
    *
    * @var int
    */
    public $id;

    /**
    * ID da loja onde a pessoa está cadastrada
    *
    * @var int
    */
    public $id_loja;

    /**
    * Nome/Razão social da pessoa
    *
    * @var string
    */
    public $nome_razao;

    /**
    * Nome fantasia da pessoa
    *
    * @var string
    */
    public $nome_fantasia;

    /**
    * RG ou IE da pessoa
    *
    * @var string
    */
    public $rg_ie;

    /**
    * CPF ou CNPJ da pessoa
    *
    * @var string
    */
    public $cpf_cnpj;

    /**
    * Tipo de contribuinte
    *
    * @var int
    */
    public $tipo_contribuinte;

    /**
    * Email da pessoa
    *
    * @var string
    */
    public $email;

    /**
    * Observações sobre pedidos da pessoa
    *
    * @var string
    */
    public $obs_pedidos;

    /**
    * Observações internas sobre a pessoa
    *
    * @var string
    */
    public $obs_interna;

    /**
    * ID da tabela de preços
    *
    * @var int
    */
    public $id_tabela_preco;

    /**
    * ID da classificação da pessoa
    *
    * @var string
    */
    public $id_classificacao;

    /**
    * Indica se é cliente
    *
    * @var int
    */
    public $eh_cliente;

    /**
    * Indica se é fornecedor
    *
    * @var int
    */
    public $eh_fornecedor;

    /**
    * Indica se é transportadora
    *
    * @var int
    */
    public $eh_transportadora;

    /**
    * Indica se é funcionário
    *
    * @var int
    */
    public $eh_funcionario;

    /**
    * Situação da pessoa (ativo ou inativo)
    *
    * @var bool
    */
    public $situacao;

    /**
    * CEP da pessoa
    *
    * @var string
    */
    public $cep;

    /**
    * Logradouro da pessoa
    *
    * @var string
    */
    public $logradouro;

    /**
    * Número do endereço da pessoa
    *
    * @var string
    */
    public $numero;

    /**
    * Complemento do endereço da pessoa
    *
    * @var string
    */
    public $complemento;

    /**
    * Bairro da pessoa
    *
    * @var string
    */
    public $bairro;

    /**
    * Cidade da pessoa
    *
    * @var string
    */
    public $cidade;

    /**
    * Estado da pessoa
    *
    * @var string
    */
    public $estado;

    /**
    * Nome do telefone da pessoa
    *
    * @var string
    */
    public $nome_fone;

    /**
    * Telefone da pessoa
    *
    * @var string
    */
    public $telefone;

    /**
    * Data e hora de cadastro da pessoa
    *
    * @var string
    */
    public $data_cadastro;

    /**
    * Data e hora de modificação da pessoa
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
        $this->id = (new Database('clientes'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome_razao' => $this->nome_razao,
            'nome_fantasia' => $this->nome_fantasia,
            'rg_ie' => $this->rg_ie,
            'cpf_cnpj' => $this->cpf_cnpj,
            'tipo_contribuinte' => $this->tipo_contribuinte,
            'email' => $this->email,
            'obs_pedidos' => $this->obs_pedidos,
            'obs_interna' => $this->obs_interna,
            'id_tabela_preco' => $this->id_tabela_preco,
            'id_classificacao' => $this->id_classificacao,
            'eh_cliente' => $this->eh_cliente,
            'eh_fornecedor' => $this->eh_fornecedor,
            'eh_transportadora' => $this->eh_transportadora,
            'eh_funcionario' => $this->eh_funcionario,
            'situacao' => $this->situacao,
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'nome_fone' => $this->nome_fone,
            'telefone' => $this->telefone,
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
        return (new Database('clientes'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome_razao' => $this->nome_razao,
            'nome_fantasia' => $this->nome_fantasia,
            'rg_ie' => $this->rg_ie,
            'cpf_cnpj' => $this->cpf_cnpj,
            'tipo_contribuinte' => $this->tipo_contribuinte,
            'email' => $this->email,
            'obs_pedidos' => $this->obs_pedidos,
            'obs_interna' => $this->obs_interna,
            'id_tabela_preco' => $this->id_tabela_preco,
            'id_classificacao' => $this->id_classificacao,
            'eh_cliente' => $this->eh_cliente,
            'eh_fornecedor' => $this->eh_fornecedor,
            'eh_transportadora' => $this->eh_transportadora,
            'eh_funcionario' => $this->eh_funcionario,
            'situacao' => $this->situacao,
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'nome_fone' => $this->nome_fone,
            'telefone' => $this->telefone,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
        ]);
    }

    /**
     * Método responsável por "excluir" uma pessoa do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI A PESSOA NO BANCO DE DADOS
        return (new Database('clientes'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);
    }
    
    /**
     * Método responsável por retornar a entidade através do id da loja e id
     *
     * @param  int $id_loja
     * @param  int $id
     * @return Entity
     */
    public static function getEntity($id_loja,$id) {
        return self::getEntities('id_loja = '.$id_loja.' AND '.'id = '.$id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar entidades através do seu uuid
     *
     * @param  string $uuid
     * @return Entity
     */
    public static function getEntityByUuid($uuid) {
        return self::getEntities('uuid = "'.$uuid.'"')->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar as entidades cadastradas em uma loja
     *
     * @param  int $id_loja
     * @return PDOStatement
     */
    public static function getCategoriesByShop($id_loja) {
        return self::getEntities('id_loja = '.$id_loja);
    }
    
    /**
     * Método responsável por retornar entidades
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getEntities($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('clientes'))->select($where,$order,$limit,$fields);
    }   
}