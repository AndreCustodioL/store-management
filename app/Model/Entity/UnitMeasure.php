<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class UnitMeasure {    
    /**
    * UUID (Universally Unique Identifier) da unidade de medida
    *
    * @var string
    */
    public $uuid;

    /**
    * ID da unidade de medida
    *
    * @var int
    */
    public $id;

    /**
    * ID da loja associada a esta unidade de medida
    *
    * @var int
    */
    public $id_loja;

    /**
    * Nome da unidade de medida
    *
    * @var string
    */
    public $nome;

    /**
    * Sigla da unidade de medida
    *
    * @var string
    */
    public $sigla;

    /**
    * Indica se a unidade de medida é fracionável
    *
    * @var bool
    */
    public $fracionavel;

    /**
    * Situação da unidade de medida (ativo ou inativo)
    *
    * @var bool
    */
    public $situacao;

    /**
    * Data e hora de cadastro da unidade de medida
    *
    * @var string
    */
    public $data_cadastro;

    /**
    * Data e hora de modificação da unidade de medida
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
        $this->id = (new Database('unidade_medida'))->insert([
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'sigla' => $this->sigla,
            'fracionavel' => $this->fracionavel,
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
        return (new Database('unidade_medida'))->update('uuid = "'.$this->uuid.'"',[
            'uuid' => $this->uuid,
            'id' => $this->id,
            'id_loja' => $this->id_loja,
            'nome' => $this->nome,
            'sigla' => $this->sigla,
            'fracionavel' => $this->fracionavel,
            'situacao' => $this->situacao,
            'data_cadastro' => $this->data_cadastro,
            'data_modificacao' => $this->data_modificacao,
            'id_usuario_cadastro' => $this->id_usuario_cadastro,
            'id_usuario_modificacao' => $this->id_usuario_modificacao,
        ]);
    }

    /**
     * Método responsável por "excluir" uma unidade de medida do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //EXCLUI A UNIDADE DE MEDIDA NO BANCO DE DADOS
        return (new Database('unidade_medida'))->update('uuid = "'.$this->uuid.'"',[
            'situacao' => 0
        ]);
    }
    
    /**
     * Método responsável por retornar as unidades de medida através do seu uuid
     *
     * @param  string $uuid
     * @return UnitMeasure
     */
    public static function getUnitMeasureByUuid($uuid){
        return self::getUnits('uuid = "'.$uuid.'"')->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar as unidades de medida através do seu id e da loja
     *
     * @param  int $id_loja
     * @param  int $id
     * @return UnitMeasure
     */
    public static function getUnitMeasureById($id_loja,$id) {
        return self::getUnits('id_loja = '.$id_loja.' AND '.'id = '.$id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar as unidades de medida cadastradas em uma loja
     *
     * @param  int $id_loja
     * @return PDOStatement
     */
    public static function getUnitsByShop($id_loja) {
        return self::getUnits('id_loja = '.$id_loja);
    }
    
    /**
     * Método responsável por retornar unidades de medida
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getUnits($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('unidade_medida'))->select($where,$order,$limit,$fields);
    }


}