<!-- <?php
require_once '../../config/database.php';
require_once '../auth_check.php'; 
session_start();

$message = "";
$status = "";

// --- TRAITEMENT DU FORMULAIRE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_SERVER['POST']['nom'] ?? '');
    $description = trim($_SERVER['POST']['description'] ?? '');
    $latitude = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
    $longitude = !empty($_POST['longitude']) ? $_POST['longitude'] : null;
    $est_active = isset($_POST['est_active']) ? 1 : 0;
    
    $photo_url = null;

    // Gestion de l'upload d'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $newName = "ville_" . time() . "." . $ext;
            $uploadDir = "../../assets/img/villes/";
            
            // Créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $newName)) {
                $photo_url = "/assets/img/villes/" . $newName;
            }
        }
    }

    // Insertion en base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO ville (nom, description, latitude, longitude, photo_url, est_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $latitude, $longitude, $photo_url, $est_active]);
        
        header("Location: index.php?success=1");
        exit();
    } catch (PDOException $e) {
        $message = "Erreur lors de l'ajout : " . $e->getMessage();
        $status = "danger";
    }
}

$title = 'Ajouter une ville - BeninExplore';
ob_start();
?>

<div class="admin-page py-4 px-3 px-md-5">
    <div class="mb-4">
        <a href="index.php" class="text-decoration-none text-muted small">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
        <h4 class="fw-bold mt-2">Nouveauté : Ajouter une destination</h4>
    </div>

    <?php if($message): ?>
        <div class="alert alert-<?= $status ?>"><?= $message ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <form action="" method="POST" enctype="multipart/form-data" class="data-card p-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Nom de la ville</label>
                        <input type="text" name="nom" class="form-control rounded-pill" placeholder="Ex: Grand-Popo" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Description</label>
                        <textarea name="description" class="form-control" rows="4" style="border-radius: 15px;" placeholder="Décrivez les atouts touristiques..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Latitude</label>
                        <input type="text" name="latitude" class="form-control rounded-pill" placeholder="6.2345">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Longitude</label>
                        <input type="text" name="longitude" class="form-control rounded-pill" placeholder="1.2345">
                    </div>

                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold small d-block">Image de couverture</label>
                        <div class="input-group">
                            <input type="file" name="photo" class="form-control" id="inputGroupFile02">
                        </div>
                        <div class="form-text">Format recommandé : JPG, PNG ou WebP (Max 2Mo).</div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="est_active" id="activeSwitch" checked>
                            <label class="form-check-label" for="activeSwitch">Afficher cette ville sur le site public</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button type="reset" class="btn btn-light rounded-pill px-4 me-2">Annuler</button>
                        <button type="submit" class="btn btn-success rounded-pill px-5" style="background-color: #008751;">Enregistrer la ville</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-lg-4">
            <div class="data-card p-4 bg-light border-0">
                <h6 class="fw-bold text-success"><i class="fas fa-lightbulb me-2"></i>Conseil Pro</h6>
                <p class="small text-muted">Utilisez des descriptions captivantes pour attirer les voyageurs. Les coordonnées GPS permettent d'afficher la ville précisément sur la carte interactive du Bénin.</p>
                <hr>
                <div class="text-center py-3">
                    <i class="fas fa-map-marked-alt fa-3x text-muted opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?> --> -->