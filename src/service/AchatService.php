<?php

namespace App\Service;

use App\Ripository\AchatRipository;
use App\Ripository\CompteurRipository;
use App\Ripository\ClientRipository;
use App\Entity\Achat;
use App\Entity\Compteur;
use App\Entity\Client;

class AchatService
{
    private $achatRepository;
    private $compteurRepository;
    private $clientRepository;

    public function __construct()
    {
        $this->achatRepository = new AchatRipository();
        $this->compteurRepository = new CompteurRipository();
        $this->clientRepository = new ClientRipository();
    }

    public function acheter(string $numeroCompteur, float $montant): array
    {
        $compteur = $this->compteurRepository->findByNumero($numeroCompteur);
        if (!$compteur) {
            return [
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => 'Le numéro de compteur non retrouvé'
            ];
        }
        $client = $this->clientRepository->findById($compteur->getClientId());
        if (!$client) {
            return [
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => 'Client non trouvé pour ce compteur'
            ];
        }
        // Simulation tranches (exemple)
        $tranche = '1';
        $prixKwh = 100; // à adapter selon la logique réelle
        $nbreKwt = $montant / $prixKwh;
        $reference = uniqid('ACHAT_');
        $code = strtoupper(bin2hex(random_bytes(4)));
        $date = date('Y-m-d H:i:s');
        $achat = new Achat(
            $reference,
            $code,
            $date,
            $tranche,
            $prixKwh,
            $nbreKwt,
            $montant,
            'success',
            $compteur->getId(),
            $client->getId()
        );
        $this->achatRepository->save($achat);
        return [
            'data' => [
                'compteur' => $numeroCompteur,
                'reference' => $reference,
                'code' => $code,
                'date' => $date,
                'tranche' => $tranche,
                'prix' => $prixKwh,
                'nbreKwt' => $nbreKwt,
                'client' => $client->getNom() . ' ' . $client->getPrenom()
            ],
            'statut' => 'success',
            'code' => 200,
            'message' => 'Achat effectué avec succès'
        ];
    }
}
