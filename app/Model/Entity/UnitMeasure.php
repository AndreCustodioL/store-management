<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class UnitMeasure {    
    /**
     * ID da unidade de medida
     *
     * @var int
     */
    public $id;    
    /**
     * ID da loja onde a unidade de medida está cadastrada
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
     * Situacao (ativo ou inativo) da unidade de medida
     *
     * @var boolean
     */
    public $situacao;
    
    /**
     * Método responsável por retornar as unidades de medida atráves do seu id e da loja
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
        return (new Database('unidades_medida'))->select($where,$order,$limit,$fields);
    }


}