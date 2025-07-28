<?php

namespace App\Ripository;

use App\Entity\Client;
use App\Core\AbstracteRipository;
use PDO;

class ClientRipository extends AbstracteRipository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findById(int $id): ?Client
    {
        $sql = "SELECT * FROM client WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Client::toObject($data) : null;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM client";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($item) => Client::toObject($item), $data);
    }
}
