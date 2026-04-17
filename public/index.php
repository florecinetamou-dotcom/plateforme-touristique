<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Définir ROOT_PATH en premier (avant toute utilisation)
define('ROOT_PATH', dirname(__DIR__));

// Définir le fuseau horaire
date_default_timezone_set('Africa/Porto-Novo');

// Démarrer la session
session_start();

// Charger l'autoloader Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Charger les variables d'environnement
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Constantes
define('BASE_URL', $_ENV['APP_URL'] ?? 'http://tourisme_benin.test');

// Router
use Core\Router;

// Charger les routes
$routes = require ROOT_PATH . '/app/config/routes.php';
$router = new Router($routes);

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);