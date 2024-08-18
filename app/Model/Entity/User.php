<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User{
    
    /**
     * ID do usuário
     *
     * @var int
     */
    public $id;
    
    /**
     * ID da loja do usuário
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
     * Método responsável por cadastrar a instãncia atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('usuarios'))->insert([
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);

        //SUCESSO
        return true;
    }
    
    /**
     * Método responsável por atualizar os dados no banco
     *
     * @return boolen
     */
    public function atualizar(){
        return (new Database('usuarios'))->update('id = '.$this->id,[
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);
    }
    
    /**
     * Método responsável por excluir os dados no banco
     *
     * @return boolen
     */
    public function excluir(){
        return (new Database('usuarios'))->delete('id = '.$this->id);
    }
    
    /**
     * Método responsável por retornar um usuário com base no seu id
     *
     * @param  int $id
     * @return User
     */
    public static function getUserById($id){
        return self::getUsers('id = '.$id)->fetchObject(self::class);
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