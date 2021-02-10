<?php

namespace src\Models;


use src\Models\ActiveRecordEntity;
class EmailProviderModel extends ActiveRecordEntity{
    protected $id;
    protected $emailProvider;
    
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getEmailProvider(){
        return $this->emailProvider;
    }
    
    public function setEmailProvider($emailProvider){
        $this->emailProvider = $emailProvider;
    }


    static protected function getTableName(): string{
        return "emailProviders";
    }

    public function getJSON(){
        $obj["emailProvider"] = $this->emailProvider;
        $obj["id"] = $this->id;

        return json_encode($obj);
    }
}
?>