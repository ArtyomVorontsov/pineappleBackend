<?php
   

    return [
        "|^api/getEmails$|" => [src\Controllers\EmailController::class, "getEmails"],
        "|^api/addEmail$|" => [src\Controllers\EmailController::class, "addEmail"],
        "|^api/deleteEmail/(\d+)$|" => [src\Controllers\EmailController::class, "deleteEmail"],
    ]    
?>