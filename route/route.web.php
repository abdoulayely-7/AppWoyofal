<?php

use App\Core\App;
use App\Controller\AchatController;

return $routes = [
    // Méthode, URI, [Contrôleur, méthode]
    ['POST', '/api/achat', [AchatController::class, 'acheter']],
    // Ajoute d'autres routes si besoin
];
