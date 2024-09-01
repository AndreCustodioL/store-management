<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User{
    
    /**
    * UUID (Universally Unique Identifier) do usuário
    *
    * @var string
    */
    public $uuid;

    /**
    * ID do usuário
    *
    * @var int
    */
    public $id;

    /**
    * ID da loja associada a este usuário
    *
    * @var int
    */
    public $id_loja;

    /**
    * Nome do usuário
    *
    * @var string
    */
    public $nome;

    /**
    * Nome de usuário (login)
    *
    * @var string
    */
    public $usuario;

    /**
    * Email do usuário
    *
    * @var string
    */
    public $email;

    /**
    * Senha do usuário
    *
    * @var string
    */
    public $senha;

    /**
    * Situação do usuário (ativo ou inativo)
    *
    * @var bool
    */
    public $situacao;

    /**
    * Data e hora de criação do usuário
    *
    * @var string
    */
    public $data_criacao;

    /**
    * Data e hora de modificação do usuário
    *
    * @var string
    */
    public $data_modificacao;

    /**
    * Data e hora do último acesso do usuário
    *
    * @var string
    */
    public $data_ult_acesso;
    
    /**
     * Método responsável por cadastrar a instãncia atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('usuarios'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'usuario' => $this->usuario,
            'email' => $this->email,
            'senha' => $this->senha,
            'situacao' => $this->situacao,
            'data_criacao' => $this->data_criacao,
            'data_modificacao' => $this->data_modificacao,
            'data_ult_acesso' => $this->data_ult_acesso,
        ]);

        //SUCESSO
        return true;
    }
    
    /**
     * Método responsável por atualizar os dados no banco
     *
     * @return boolean
     */
    public function atualizar(){
        return (new Database('usuarios'))->update('uuid = '.$this->uuid,[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'usuario' => $this->usuario,
            'email' => $this->email,
            'senha' => $this->senha,
            'situacao' => $this->situacao,
            'data_criacao' => $this->data_criacao,
            'data_modificacao' => $this->data_modificacao,
            'data_ult_acesso' => $this->data_ult_acesso,
        ]);
    }
    
    /**
     * Método responsável por excluir os dados no banco
     *
     * @return boolean
     */
    public function excluir(){
        return (new Database('usuarios'))->delete('id = '.$this->id);
    }
    
    /**
     * Método responsável por retornar um usuário com base no seu uuid
     *
     * @param  string $uuid
     * @return User
     */
    public static function getUserByUuid($uuid){
        return self::getUsers('uuid = '.$uuid)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar um usuário com base em seu email
     *
     * @param  string $email
     * @return User
     */
    public static function getUserByEmail($email){
        return self::getUsers('email ="'.$email.'"')->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar Usuários
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('usuarios'))->select($where,$order,$limit,$fields);
    }

}