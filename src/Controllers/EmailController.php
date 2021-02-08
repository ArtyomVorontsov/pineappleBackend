<?php

namespace src\Controllers;

use src\Models\EmailModel;
use src\Models\EmailProviderModel;

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

      //check if this provider exists in db
      $emailProviderFromDb = EmailProviderModel::getOneBy("email", $emailProvider);
      var_dump($emailProviderFromDb);

      //and if not exists we add new provider to emailsProvider table
      if($emailProviderFromDb === NULL ){
         $newEmailProvider = new EmailProviderModel();
         $newEmailProvider->setEmailProvider($emailProvider);
         $newEmailProvider->save();
      };

      
      $emailInstance = new EmailModel();
      $emailInstance->setEmail($emailFromURl);
      $emailInstance->setEmailProvider($emailProvider);

      $emailInstance->save();

      //we get new email after saving it in db
      $newEmail = EmailModel::getLast();


      //we update our created emailInstance object
      $emailInstance->setEmail($newEmail->getEmail());
      $emailInstance->setEmailProvider($newEmail->getEmailProvider());
      $emailInstance->setId($newEmail->getId());
      $emailInstance->setCreatedAt($newEmail->getCreatedAt());

      var_dump($emailInstance);
   }
}
