<?php

require_once '../app/config/bootstrap.php';

try {
    $pdo = \App\Core\Database::getInstance();
    echo "Connexion à la base de données réussie.<br>";
} catch (Exception $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}