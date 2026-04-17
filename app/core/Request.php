<?php
namespace Core;

class Request {
    
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function isPost() {
        return $this->getMethod() === 'POST';
    }
    
    public function isGet() {
        return $this->getMethod() === 'GET';
    }
    
    public function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    public function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }
    
    public function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }
    
    public function all() {
        return array_merge($_GET, $_POST);
    }
    
    public function getUri() {
        return $_SERVER['REQUEST_URI'];
    }
}