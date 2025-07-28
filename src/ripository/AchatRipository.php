<?php

namespace App\Ripository;

use App\Entity\Achat;
use App\Core\AbstracteRipository;
use PDO;

class AchatRipository extends AbstracteRipository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save(Achat $achat): bool
    {
        $sql = "INSERT INTO achat (reference, code, date, tranche, prix, nbreKwt, montant, statut, compteur_id, client_id)
                VALUES (:reference, :code, :date, :tranche, :prix, :nbreKwt, :montant, :statut, :compteur_id, :client_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'reference' => $achat->getReference(),
            'code' => $achat->getCode(),
            'date' => $achat->getDate(),
            'tranche' => $achat->getTranche(),
            'prix' => $achat->getPrix(),
            'nbreKwt' => $achat->getNbreKwt(),
            'montant' => $achat->getMontant(),
            'statut' => $achat->getStatut(),
            'compteur_id' => $achat->getCompteurId(),
            'client_id' => $achat->getClientId()
        ]);
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM achat";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($item) => Achat::toObject($item), $data);
    }

    public function findByReference(string $reference): ?Achat
    {
        $sql = "SELECT * FROM achat WHERE reference = :reference";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['reference' => $reference]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Achat::toObject($data) : null;
    }

    public function findByCompteur(string $numero): array
    {
        $sql = "SELECT a.* FROM achat a JOIN compteur c ON a.compteur_id = c.id WHERE c.numero = :numero";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numero' => $numero]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($item) => Achat::toObject($item), $data);
    }

    public function findByClient(int $clientId): array
    {
        $sql = "SELECT * FROM achat WHERE client_id = :client_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['client_id' => $clientId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($item) => Achat::toObject($item), $data);
    }
}
