<?php

namespace App\Ripository;

use App\Entity\Compteur;
use App\Core\AbstracteRipository;
use PDO;

class CompteurRipository extends AbstracteRipository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findByNumero(string $numero): ?Compteur
    {
        $sql = "SELECT * FROM compteur WHERE numero = :numero";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numero' => $numero]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Compteur::toObject($data) : null;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM compteur";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($item) => Compteur::toObject($item), $data);
    }
}
