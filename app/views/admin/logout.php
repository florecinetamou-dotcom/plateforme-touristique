<?php
session_start();
session_destroy(); // On détruit toutes les données de session
header("Location: login.php"); // Retour à la case départ
exit();