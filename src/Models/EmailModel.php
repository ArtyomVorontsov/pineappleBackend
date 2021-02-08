<?php

namespace src\Models;


use src\Models\ActiveRecordEntity;
class EmailModel extends ActiveRecordEntity{
    private $email;
    private $id;
    private $emailProvider;
    private $createdAt;

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

    public function getId(){
        return $this->id;
    }


    static protected function getTableName(): string{
        return "emails";
    }
    
   
}

?>