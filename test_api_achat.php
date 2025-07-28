<?php
// Fichier de test pour l'API d'achat Woyofal

$url = 'http://localhost:8000/api/achat';
$data = [
    'compteur' => 'CPT10001',
    'montant' => 1000
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
    echo "Erreur lors de l'appel à l'API";
} else {
    echo "Réponse de l'API :\n";
    echo $result;
}
