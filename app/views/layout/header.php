<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO -->
    <title><?= htmlspecialchars($title ?? 'BeninExplore - Tourisme au Bénin') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Découvrez les merveilles du Bénin : sites historiques, nature, culture et hébergements.') ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph (partage sur réseaux sociaux) -->
    <meta property="og:title" content="<?= htmlspecialchars($title ?? 'BeninExplore') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_description ?? 'Découvrez les merveilles du Bénin') ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        :root {
            --benin-green: #008751;
            --benin-yellow: #FFD600;
            --benin-red: #E8112D;
            --benin-gradient: linear-gradient(135deg, #008751 0%, #006B40 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 5px 20px rgba(0,135,81,0.15);
        }

        * { 
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body { 
            padding-top: 72px;
            background-color: #fafafa;
            color: #1a1a2e;
        }

        /* Boutons */
        .btn-benin { 
            background: var(--benin-gradient);
            color: white; 
            border: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .btn-benin:hover { 
            transform: translateY(-2px); 
            color: white;
            box-shadow: var(--shadow-md);
            filter: brightness(1.05);
        }
        .btn-outline-benin {
            border: 2px solid var(--benin-green);
            color: var(--benin-green);
            background: transparent;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-benin:hover {
            background: var(--benin-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Couleurs utilitaires */
        .bg-benin { background: var(--benin-gradient); }
        .text-benin { color: var(--benin-green) !important; }
        .border-benin { border-color: var(--benin-green) !important; }

        /* Cartes */
        .card {
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md) !important;
        }

        /* Alertes flash */
        .flash-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1055;
            min-width: 320px;
            max-width: 420px;
        }
        .flash-container .alert {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
            border: none;
            font-size: 0.9rem;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Badge catégorie */
        .badge.bg-purple { background-color: #6f42c1 !important; }

        /* Liens */
        a { color: var(--benin-green); }
        a:hover { color: #006B40; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Messages flash (position fixe, coin supérieur droit) -->
<div class="flash-container">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['warning'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($_SESSION['warning']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['info'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['info']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['info']); ?>
    <?php endif; ?>
</div>

<main>