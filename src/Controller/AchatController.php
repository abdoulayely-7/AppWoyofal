<?php

namespace App\Controller;

use App\Service\AchatService;

class AchatController
{
    private AchatService $achatService;

    public function __construct()
    {
        $this->achatService = new AchatService();
    }

    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function acheter()
    {
        $this->setCorsHeaders();
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $numeroCompteur = $input['compteur'] ?? null;
        $montant = $input['montant'] ?? null;
        if (!$numeroCompteur || !$montant) {
            http_response_code(400);
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Le numéro de compteur et le montant sont obligatoires'
            ]);
            exit;
        }
        $result = $this->achatService->acheter($numeroCompteur, (float)$montant);
        http_response_code($result['code']);
        echo json_encode($result);
        exit;
    }
}
