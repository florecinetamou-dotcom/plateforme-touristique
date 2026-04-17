<?php
namespace Core;

class Router {
    private $routes = [];
    
    public function __construct($routes) {
        $this->routes = $routes;
    }
    
    public function dispatch($url) {
        // Nettoyer l'URL
        $url = parse_url($url, PHP_URL_PATH);
        $url = rtrim($url, '/');
        
        // Construire le chemin complet
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/tourisme_benin' . $url;
        
        // Si c'est un fichier qui existe, on le serve directement
        if (file_exists($filePath) && !is_dir($filePath)) {
            if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                require $filePath;
                exit;
            }
            return false;
        }
        
        // Si c'est un dossier qui existe
        if (file_exists($filePath) && is_dir($filePath)) {
            $indexPath = $filePath . '/index.php';
            if (file_exists($indexPath)) {
                require $indexPath;
                exit;
            }
            echo "<h1>Contenu du dossier " . basename($filePath) . "</h1>";
            echo "<ul>";
            $files = scandir($filePath);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $icon = $ext === 'php' ? '🐘' : ($ext === 'html' ? '📄' : '📁');
                    echo "<li><a href='$url/$file'>$icon $file</a></li>";
                }
            }
            echo "</ul>";
            exit;
        }
        
        // Enlever /public du début si présent
        if (strpos($url, '/public') === 0) {
            $url = substr($url, 7);
        }
        
        // Si l'URL est vide, mettre '/'
        if (empty($url)) {
            $url = '/';
        }
        
        // 1. Correspondance exacte d'abord
        if (isset($this->routes[$url])) {
            $this->callHandler($this->routes[$url], []);
            return;
        }
        
        // 2. Routes dynamiques avec {param}
        foreach ($this->routes as $pattern => $handler) {
            // Convertir /site/{id} en regex #^/site/([^/]+)$#
            $regex = preg_replace('/\{[^}]+\}/', '([^/]+)', $pattern);
            $regex = '#^' . $regex . '$#';
            
            if (preg_match($regex, $url, $matches)) {
                array_shift($matches); // Enlever le match complet, garder les paramètres
                $this->callHandler($handler, $matches);
                return;
            }
        }
        
        // 404
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 - Page non trouvée</h1>";
        echo "<p>L'URL '$url' n'existe pas.</p>";
        echo "<p>Routes disponibles :</p>";
        echo "<ul>";
        foreach (array_keys($this->routes) as $route) {
            echo "<li><a href='$route'>$route</a></li>";
        }
        echo "</ul>";
        echo "<p><a href='/public/tests/'>🔧 Aller vers les tests</a></p>";
    }
    
    /**
     * Instancie le contrôleur et appelle la méthode avec les paramètres
     */
    private function callHandler($handler, $params) {
        $controller = $handler[0];
        $action = $handler[1];

        if (!class_exists($controller)) {
            // Convertir le namespace en chemin de fichier
            $filePath = str_replace(
                ['App\\Controllers\\Admin\\', 'App\\Controllers\\Front\\', 'App\\Controllers\\Hebergeur\\', 'App\\Models\\', 'Core\\', '\\'],
                ['app/controllers/admin/', 'app/controllers/front/', 'app/controllers/hebergeur/', 'app/models/', 'app/core/', '/'],
                $controller
            ) . '.php';

            $fullPath = ROOT_PATH . '/' . $filePath;

            if (file_exists($fullPath)) {
                require_once $fullPath;
            } else {
                echo "Erreur : Le contrôleur '$controller' n'existe pas — fichier cherché : $fullPath";
                return;
            }
        }

        if (class_exists($controller)) {
            $obj = new $controller();
            if (method_exists($obj, $action)) {
                $obj->$action(...$params);
            } else {
                echo "Erreur : La méthode '$action' n'existe pas dans $controller";
            }
        } else {
            echo "Erreur : La classe '$controller' n'existe pas après chargement";
        }
    }
}