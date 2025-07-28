<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dsn = $_ENV['DSN'] ?? $_ENV['DSN'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];

class Seeder {
    public static function seed() {
        $pdo = new PDO($GLOBALS['dsn'], $GLOBALS['user'], $GLOBALS['pass']);

        // Seed clients
        $clients = [
            ['nom' => 'Sow', 'prenom' => 'Fatou'],
            ['nom' => 'Ndiaye', 'prenom' => 'Moussa'],
            ['nom' => 'Fall', 'prenom' => 'Aminata']
        ];
        $sqlClient = "INSERT INTO client (nom, prenom) VALUES (:nom, :prenom)";
        $stmtClient = $pdo->prepare($sqlClient);
        foreach ($clients as $client) {
            $stmtClient->execute($client);
        }
        echo count($clients) . " clients seedés avec succès.\n";

        // Récupérer les IDs clients
        $clientIds = $pdo->query("SELECT id FROM client")->fetchAll(PDO::FETCH_COLUMN);

        // Seed compteurs
        $compteurs = [
            ['numero' => 'CPT10001', 'client_id' => $clientIds[0]],
            ['numero' => 'CPT10002', 'client_id' => $clientIds[1]],
            ['numero' => 'CPT10003', 'client_id' => $clientIds[2]]
        ];
        $sqlCompteur = "INSERT INTO compteur (numero, client_id) VALUES (:numero, :client_id)";
        $stmtCompteur = $pdo->prepare($sqlCompteur);
        foreach ($compteurs as $compteur) {
            $stmtCompteur->execute($compteur);
        }
        echo count($compteurs) . " compteurs seedés avec succès.\n";

        // Optionnel : seed achat de test
        $achats = [
            [
                'reference' => 'ACHAT_TEST1',
                'code' => 'CODE1234',
                'date' => date('Y-m-d H:i:s'),
                'tranche' => '1',
                'prix' => 100,
                'nbreKwt' => 5,
                'montant' => 500,
                'statut' => 'success',
                'compteur_id' => 1,
                'client_id' => 1
            ]
        ];
        $sqlAchat = "INSERT INTO achat (reference, code, date, tranche, prix, nbreKwt, montant, statut, compteur_id, client_id)
                     VALUES (:reference, :code, :date, :tranche, :prix, :nbreKwt, :montant, :statut, :compteur_id, :client_id)";
        $stmtAchat = $pdo->prepare($sqlAchat);
        foreach ($achats as $achat) {
            $stmtAchat->execute($achat);
        }
        echo count($achats) . " achats seedés avec succès.\n";
    }
}

Seeder::seed();