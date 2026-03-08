<!-- <?php
require_once '../../config/database.php';
require_once '../auth_check.php'; 
session_start();

$message = "";
$status = "";

// 1. Récupération de la ville à modifier
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM ville WHERE id = ?");
    $stmt->execute([$id]);
    $ville = $stmt->fetch();

    if (!$ville) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// 2. Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $latitude = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
    $longitude = !empty($_POST['longitude']) ? $_POST['longitude'] : null;
    $est_active = isset($_POST['est_active']) ? 1 : 0;
    
    $photo_url = $ville->photo_url; // Par défaut, on garde l'ancienne image

    // Gestion du nouvel upload d'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $newName = "ville_" . time() . "." . $ext;
            $uploadDir = "../../assets/img/villes/";
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $newName)) {
                // Supprimer l'ancienne image du serveur si elle existe
                if ($ville->photo_url && file_exists("../.." . $ville->photo_url)) {
                    unlink("../.." . $ville->photo_url);
                }
                $photo_url = "/assets/img/villes/" . $newName;
            }
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE ville SET nom = ?, description = ?, latitude = ?, longitude = ?, photo_url = ?, est_active = ? WHERE id = ?");
        $stmt->execute([$nom, $description, $latitude, $longitude, $photo_url, $est_active, $id]);
        
        header("Location: index.php?updated=1");
        exit();
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour : " . $e->getMessage();
        $status = "danger";
    }
}

$title = 'Modifier ' . htmlspecialchars($ville->nom);
ob_start();
?>

<div class="admin-page py-4 px-3 px-md-5">
    <div class="mb-4">
        <a href="index.php" class="text-decoration-none text-muted small">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
        <h4 class="fw-bold mt-2">Modifier la destination : <?= htmlspecialchars($ville->nom) ?></h4>
    </div>

    <?php if($message): ?>
        <div class="alert alert-<?= $status ?>"><?= $message ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <form action="" method="POST" enctype="multipart/form-data" class="data-card p-4 shadow-sm bg-white">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Nom de la ville</label>
                        <input type="text" name="nom" class="form-control rounded-pill" value="<?= htmlspecialchars($ville->nom) ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Description</label>
                        <textarea name="description" class="form-control" rows="4" style="border-radius: 15px;"><?= htmlspecialchars($ville->description) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Latitude</label>
                        <input type="text" name="latitude" class="form-control rounded-pill" value="<?= $ville->latitude ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Longitude</label>
                        <input type="text" name="longitude" class="form-control rounded-pill" value="<?= $ville->longitude ?>">
                    </div>

                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold small d-block">Image de couverture</label>
                        <?php if($ville->photo_url): ?>
                            <div class="mb-3">
                                <img src="<?= $ville->photo_url ?>" class="rounded shadow-sm" style="width: 150px; height: 100px; object-fit: cover;">
                                <p class="smaller text-muted mt-1">Image actuelle</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="photo" class="form-control">
                        <div class="form-text text-info">Laissez vide pour conserver l'image actuelle.</div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="est_active" id="activeSwitch" <?= $ville->est_active ? 'checked' : '' ?>>
                            <label class="form-check-label" for="activeSwitch">Ville active (visible sur le site)</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <a href="index.php" class="btn btn-light rounded-pill px-4 me-2">Annuler</a>
                        <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="data-card p-4 border-0" style="background: #FFF9E6;">
                <h6 class="fw-bold text-warning"><i class="fas fa-info-circle me-2"></i>Note d'édition</h6>
                <p class="small text-muted">Modifier une ville mettra à jour instantanément toutes les annonces d'hébergement liées à cette destination sur le portail client.</p>
                <div class="text-center py-3">
                    <i class="fas fa-edit fa-3x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?> -->