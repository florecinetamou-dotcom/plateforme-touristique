<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class FavoriAdminController extends Controller {

    private $model;

    public function __construct() {
        $this->requireAuth('admin');
        $this->model = new Hebergement();
    }

    public function index() {
        $hebergements = $this->model->query(
            "SELECT h.id, h.nom, h.prix_nuit_base,
                    v.nom as ville_nom,
                    t.nom as type_nom,
                    COUNT(f.hebergement_id) as nb_favoris,
                    (SELECT ph.url FROM photo_hebergement ph
                     WHERE ph.hebergement_id = h.id AND ph.est_principale = 1
                     LIMIT 1) as photo
             FROM hebergement h
             JOIN favori f ON f.hebergement_id = h.id
             JOIN ville v ON h.ville_id = v.id
             LEFT JOIN type_hebergement t ON h.type_id = t.id
             GROUP BY h.id, h.nom, h.prix_nuit_base, v.nom, t.nom
             ORDER BY nb_favoris DESC"
        );

        $r = $this->model->query("SELECT COUNT(*) as nb FROM favori");
        $total_favoris = $r[0]->nb ?? 0;

        $r2 = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        $badges = ['nb_hebergements_attente' => $r2[0]->nb ?? 0];

        $this->view('admin/favoris/index', [
            'hebergements'  => $hebergements,
            'total_favoris' => $total_favoris,
            'badges'        => $badges,
        ]);
    }
}