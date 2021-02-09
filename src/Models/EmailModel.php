<?php

namespace src\Models;


use src\Models\ActiveRecordEntity;
class EmailModel extends ActiveRecordEntity{
    protected $email;
    protected $id;
    protected $emailProvider;
    protected $createdAt;


    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }


    public function getEmailProvider(){
        return $this->emailProvider;
    }
    
    public function setEmailProvider($emailProvider){
        $this->emailProvider = $emailProvider;
    }


    

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
  

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }


    static protected function getTableName(): string{
        return "emails";
    }

    public function getJSON(){

        $obj["email"] = $this->email;
        $obj["emailProvider"] = $this->emailProvider;
        $obj["id"] = $this->id;
        $obj["createdAt"] = $this->createdAt;

        return json_encode($obj);
    }
    
   
}

?>