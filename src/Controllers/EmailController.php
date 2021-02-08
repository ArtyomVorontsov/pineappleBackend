<?php

namespace src\Controllers;

use src\Models\EmailModel;

class EmailController
{
   public function getEmails()
   {

      $column = $_GET["column"];
      $order = $_GET["order"];

      
      $emailInstance = new EmailModel();
      var_dump(EmailModel::getAllBy($emailInstance, $column, $order));

   }

   public function addEmail()
   {

      $emailFromURl = $_GET["email"] ?? null;

      if (!$emailFromURl) {
         echo "Email should be passed";
         return;
      }

      $emailParts = explode("@", $emailFromURl);
      $emailProvider = $emailParts[1];

      $emailInstance = new EmailModel();
      $emailInstance->setEmail($emailFromURl);
      $emailInstance->setEmailProvider($emailProvider);


      $emailInstance->save();
      $newEmail = EmailModel::getLast();


      $emailInstance->setEmail($newEmail->getEmail());
      $emailInstance->setEmailProvider($newEmail->getEmailProvider());
      $emailInstance->setId($newEmail->getId());
      $emailInstance->setCreatedAt($newEmail->getCreatedAt());

      var_dump($emailInstance);
   }
}
