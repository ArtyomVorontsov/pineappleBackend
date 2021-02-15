<?php

    namespace src\Utils;
    
    class Utils {
        
        public static function parseArrayToJson($dataArray){
            //parsing array to JSON
            $dataJSON = "";

            foreach ($dataArray as $data)
            $dataJSON = $dataJSON . "," . $data->getJSON();
            
            //remove first character from dataJSON because it is: ","
            $dataJSON = substr($dataJSON, 1);
            $dataJSON = "[" . $dataJSON . "]";
           
            return $dataJSON;
        }
    }
