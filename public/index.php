<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Définir le fuseau horaire
date_default_timezone_set('Africa/Porto-Novo');

// Démarrer la session
session_start();

// Charger l'autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Charger les variables d'environnement
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Constantes
define('BASE_URL', $_ENV['APP_URL'] ?? 'http://tourisme_benin.test');

// Router
use Core\Router;

$routes = require __DIR__ . '/../app/config/routes.php';
$router = new Router($routes);

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);