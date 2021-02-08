<?php

namespace src\Controllers;
use src\Models\EmailModel;

class EmailController {
   public function getEmails(){
      var_dump(EmailModel::getAll());
   }

   public function addEmail(){
      $email = new EmailModel();
      $email->setEmail("JaneDoe@mail.com");
      $email->setEmailProvider("@mail.com");
      $email->save();
   }
}


?>