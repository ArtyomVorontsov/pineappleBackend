<?php

namespace src\Controllers;

use src\Exceptions\NotFoundException;
use src\Exceptions\WrongUserInputException;
use src\Models\EmailModel;
use src\Models\EmailProviderModel;

class EmailController
{
   public function getEmails()
   {
      $column = $_GET["orderBy"];
      $order = $_GET["order"];
      $emailProvider = $_GET["emailProvider"];
      $filterColumn = "emailProvider";

      $emailInstance = new EmailModel();

      //check for email provider in emailProviders table
      $existingEmailProviders = EmailProviderModel::getAll();
      $isProviderExists = false;

      //if email provider exists we go further, else we return from method
      foreach($existingEmailProviders as $existingEmailProvider){
         if($existingEmailProvider->emailProvider === $emailProvider){
            $isProviderExists = true;
            break;
         }
      }

      if(!$isProviderExists){
         throw new NotFoundException("Email provider didn't exists");
      }

      var_dump(EmailModel::getAllBy($emailInstance, $column, $order,  $filterColumn , $emailProvider));
   }

   public function deleteEmail($id){
      var_dump($id);
      $result = EmailModel::deleteById($id);

      var_dump($result);
   }



   public function addEmail()
   {
      $emailFromURl = $_GET["email"] ?? null;

      if (!$emailFromURl) {
         throw new WrongUserInputException("Email should be passed");
      }

      $emailParts = explode("@", $emailFromURl);
      $emailProviderName = $emailParts[1];

      //check if this provider exists in db
      $emailProviderFromDb = EmailProviderModel::getOneByEmailProvider($emailProviderName);
      

      //and if not exists we add new provider to emailsProvider table
      if($emailProviderFromDb == NULL){
         $newEmailProvider = new EmailProviderModel();
         $newEmailProvider->setEmailProvider($emailProviderName);
         $newEmailProvider->save();
      };


      $emailInstance = new EmailModel();
      $emailInstance->setEmail($emailFromURl);
      $emailInstance->setEmailProvider($emailProviderName);
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