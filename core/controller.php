<?php
class Controller {
    

    public static function badRequestException(string $message){
        echo json_encode([
            'status' => 400,
            'message' => $message
        ]);
        http_response_code(400);
        exit;
    }
}

?>