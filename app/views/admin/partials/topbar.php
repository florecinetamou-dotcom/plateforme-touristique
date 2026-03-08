<?php
$prenom = $_SESSION['user_prenom'] ?? 'Admin';
$nom    = $_SESSION['user_nom']    ?? '';
$initiale = strtoupper(substr($prenom, 0, 1));

// Titre de page selon l'URL
$url = $_SERVER['REQUEST_URI'];
$titles = [
    '/admin/dashboard'    => 'Tableau de bord',
    '/admin/hebergements' => 'Hébergements',
    '/admin/villes'       => 'Villes',
    '/admin/sites'        => 'Sites touristiques',
    '/admin/reservations' => 'Réservations',
    '/admin/utilisateurs' => 'Utilisateurs',
    '/admin/avis'         => 'Avis & Commentaires',
    '/admin/chatbot'      => 'Chatbot',
];

$pageTitle = 'Administration';
foreach ($titles as $path => $title) {
    if (strpos($url, $path) === 0) {
        $pageTitle = $title;
        break;
    }
}
?>
<div class="topbar">
    <div>
        <div class="topbar__title"><?= $pageTitle ?></div>
        <div class="topbar__sub"><?= date('d F Y') ?></div>
    </div>
    <div class="topbar__right">
        <div class="topbar__user">
            <div class="topbar__avatar"><?= $initiale ?></div>
            <?= htmlspecialchars($prenom . ' ' . $nom) ?>
        </div>
    </div>
</div>