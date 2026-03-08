<?php
require_once __DIR__ . '/../../vendor/autoload.php';

echo "<h1>🔍 Test des routes</h1>";

$routes = require __DIR__ . '/../../app/config/routes.php';

echo "<h2>Routes définies :</h2>";
echo "<ul>";
foreach ($routes as $route => $handler) {
    echo "<li><strong>" . htmlspecialchars($route) . "</strong> → " . $handler[0] . "::" . $handler[1] . "</li>";
}
echo "</ul>";

// Vérifier spécifiquement les routes villes
echo "<h2>Routes villes :</h2>";
$villeRoutes = array_filter(array_keys($routes), function($r) {
    return strpos($r, 'ville') !== false;
});

if (empty($villeRoutes)) {
    echo "<p style='color:red'>❌ Aucune route pour les villes !</p>";
} else {
    echo "<ul>";
    foreach ($villeRoutes as $route) {
        echo "<li style='color:green'>✅ " . $route . "</li>";
    }
    echo "</ul>";
}

echo "<p><a href='/public/tests/'>⬅️ Retour aux tests</a></p>";