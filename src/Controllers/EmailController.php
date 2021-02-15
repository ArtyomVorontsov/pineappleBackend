<?php

namespace src\Controllers;

use src\Exceptions\NotFoundException;
use src\Exceptions\WrongUserInputException;
use src\Models\EmailModel;
use src\Models\EmailProviderModel;
use src\Utils\Utils;

class EmailController extends ResponseController
{
   public function getEmails()
   {
      $column = $_GET["orderBy"] ?? "id";
      $order = $_GET["order"] ?? "DESC";
      $emailProvider = $_GET["emailProvider"] ?? null;
      $filterColumn = "emailProvider";

      $emailInstance = new EmailModel();


      if ($emailProvider) {
         //check for email provider in emailProviders table
         $existingEmailProviders = EmailProviderModel::getAll();
         $isProviderExists = false;

         //if email provider exists we go further, else we throw error
         foreach ($existingEmailProviders as $existingEmailProvider) {
            if ($existingEmailProvider->getEmailProvider() === $emailProvider) {
               $isProviderExists = true;
               break;
            }
         }

         if (!$isProviderExists)
            throw new NotFoundException("Email provider didn't exists");
      }



      $emailsArray = EmailModel::getAllBy($emailInstance, $column, $order,  $filterColumn, $emailProvider);
      //parse to JSON
      $emailsJSON = Utils::parseArrayToJson($emailsArray);

      //sending data to client
      static::sendJSON($emailsJSON);
   }

   public function deleteEmail($id)
   {
      $result = EmailModel::deleteById($id);
      static::sendJSON(json_encode($result));
   }


   public function getEmailProviders(){
      $emailProvidersArray = EmailProviderModel::getAll();
      //parse to JSON
      $emailProvidersJSON = Utils::parseArrayToJson($emailProvidersArray);
      
      //sending data to client
      static::sendJSON($emailProvidersJSON);
   }

   public function getEmailsCSV(){
      $emailsIdFromURl = $_GET["emailsId"] ?? null;

      if(!$emailsIdFromURl) 
         throw new WrongUserInputException("Id array should be provided.");

      $emailsIdArray = json_decode($emailsIdFromURl);
      $emailsArray = EmailModel::getAllWhere($emailsIdArray, "id");


      $emailsArrayCSV = [];
      foreach($emailsArray as $email){
         $emailsArrayCSV[] = array(
         $email->getEmail(), 
         $email->getEmailProvider(),
         $email->getId(),
         $email->getCreatedAt());
      }
      
      //we open write stream for csv and send it to client
      $fp = fopen('php://output', 'wb');
      header('Content-Type: text/csv');
      $ContentDispositionHeader = 'Content-Disposition: attachment; filename=' . '"emails' . $emailsIdFromURl . '.csv"';
      header($ContentDispositionHeader);
      foreach($emailsArrayCSV as $emailArray){
         fputcsv($fp, $emailArray);
      }

      fclose($fp);
   }

   public function addEmail()
   {
      $emailFromURl = $_GET["email"] ?? null;

      if (!$emailFromURl)
         throw new WrongUserInputException("Email should be passed.");

      if(!filter_var($emailFromURl, FILTER_VALIDATE_EMAIL))
         throw new WrongUserInputException("Email invalid.");

      $emailParts = explode("@", $emailFromURl);
      $emailProviderName = $emailParts[1];

      //check if this provider exists in db
      $emailProviderFromDb = EmailProviderModel::getOneByEmailProvider($emailProviderName);


      //if not exists we add new provider to emailsProvider table
      if ($emailProviderFromDb == NULL) {
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

      //sending email data to client
      static::sendJSON(($emailInstance->getJSON()));
   }
}
