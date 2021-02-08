<?php

namespace src\Models;

use ReflectionObject;
use src\Db;


abstract class ActiveRecordEntity{
    static abstract protected function getTableName(): string;

    public static function getAllBy( object $object ,string $column = "email", string $order = "DESC"){
        $db = Db::getInstance();
        $tableName = static::getTableName();

        $properties = $object->mapProperties();

        $column = in_array($column, $properties, true) ? $column : "createdAt";
        $order = $order === "DESC" ? "DESC" : "ASC";

        $sql = "SELECT * FROM `$tableName` ORDER BY $column $order";
        return $db->query($sql, [], false, static::class);
    }

    private function mapProperties(){
        $reflector = new ReflectionObject($this);
        $reflectionProperties = $reflector->getProperties();

        $properties = [];

        foreach($reflectionProperties as $reflectionProperty){
            $name = $reflectionProperty->getName();
            $properties[] = $name;
        }
    
        return $properties;
    }

    static public function getOneBy(string $column, $sougth){
        $tableName = static::getTableName();
        $sql = "SELECT * FROM `$tableName`
        WHERE :param1 = :param2
        LIMIT 1";

        $db = Db::getInstance();
        $value = $db->query($sql, ["param1" => $column, "param2" => $sougth], false, static::class);
        return $value[0];
    }

    public static function getLast(){
        $tableName = static::getTableName();
        $sql = "SELECT * FROM `$tableName`
         ORDER BY `id` DESC
         LIMIT 1";

        $db = Db::getInstance();
        $lastRowArray = $db->query($sql, [], false, static::class);
        return $lastRowArray[0];
    }

    private function insert(){
        $properties = $this->mapProperties();

        $argumentsValues = [];
        $params = [];
        $argumentsNames = [];

        $i = 0;

        foreach($properties as $property){
            if($this->$property){
                ++$i;
                $params[] = ":param" . $i;
                $argumentsValues["param" . $i] = $this->$property;
                $argumentsNames[] = $property;
            }
        }

        $tableName = $this->getTableName();

        $sql = "INSERT INTO `$tableName`" . "(" .  implode(",", $argumentsNames) . ")
        VALUES(" . implode(",", $params) . ")";

        $db = Db::getInstance();
        $db->query($sql, $argumentsValues, true);
        
    }

    private function update(){

    }

    public function save(){
        if($this->id){
            echo "update!";
            $this->update();            
        }else{
            $this->insert();
        }
       
    }
}
