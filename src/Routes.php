<?php
   

    return [
        "|^api/getEmails$|" => [src\Controllers\EmailController::class, "getEmails"],
        "|^api/addEmail$|" => [src\Controllers\EmailController::class, "addEmail"],
        "|^api/deleteEmail/(\d+)$|" => [src\Controllers\EmailController::class, "deleteEmail"],
        "|^api/getEmailProviders$|" => [src\Controllers\EmailController::class, "getEmailProviders"],
        "|^api/getEmailsCSV$|" => [src\Controllers\EmailController::class, "getEmailsCSV"],
    ]    
?>