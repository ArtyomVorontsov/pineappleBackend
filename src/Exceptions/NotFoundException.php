<?php

namespace src\Exceptions;

class NotFoundException extends CustomException{

    public function getResult(){
        echo $this->getError();
        http_response_code(404);
    }
}

?>