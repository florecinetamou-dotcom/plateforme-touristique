<?php
namespace Core;

class Response {
    
    public function setStatusCode($code) {
        http_response_code($code);
        return $this;
    }
    
    public function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    public function json($data, $statusCode = 200) {
        $this->setStatusCode($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    public function setHeader($name, $value) {
        header("$name: $value");
        return $this;
    }
}