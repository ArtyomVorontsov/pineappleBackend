<?php
    namespace src;

use Exception;
use src\Exceptions\WrongUserInputException;

class Db {

        private $_pdo;

        private function __construct(){
            try{
                $dbPropertiesArray = require __DIR__ . "/Service.php";
                $dbProperties =  $dbPropertiesArray["db"];
                $dsn =  "mysql:host=" . $dbProperties["host"] .  ";dbname=" . $dbProperties["dbname"];
    
                $this->_pdo = new \PDO($dsn, $dbProperties["username"], $dbProperties["password"]);
                $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->_pdo->exec("SET NAMES UTF8");
            }catch(Exception $e){
                throw new WrongUserInputException("Database connection error, check Service.php to setup your db connection credentials. 
                Also check if PDO MySQL driver is running.");
            }
            
        }

        

        static $instance;

        public static function getInstance(){
           
            static $instancesCount = 0;

            if($instancesCount === 0){
               self::$instance = new Db();
               ++$instancesCount;
               self::$instance;
            }

             return self::$instance;
        }

        

        public function query(string $sql, array $params = [], bool $isAdding = false, string $className = "stdClass" ): array{
            $sth = $this->_pdo->prepare($sql);
            $result = $sth->execute($params);

            if(!$result || $isAdding) return [null];

            return $sth->fetchAll(\PDO::FETCH_CLASS,$className);
        }


    }


?>