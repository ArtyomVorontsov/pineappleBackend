<?php

namespace src\Models;

use ReflectionObject;
use src\Db;


abstract class ActiveRecordEntity{
    static abstract protected function getTableName(): string;

    public static function getAll(){
        $db = Db::getInstance();
        $tableName = static::getTableName();
        $sql = "SELECT * FROM `$tableName`";
        return $db->query($sql);
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

    private function insert(){
        
    }

    public function save(){
       var_dump($this->mapProperties());



    }
}


?>