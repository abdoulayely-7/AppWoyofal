<?php

namespace App\Service;

use App\Ripository\ClientRipository;
use App\Entity\Client;

class ClientService
{
    private $clientRepository;

    public function __construct()
    {
        $this->clientRepository = new ClientRipository();
    }

    public function findById(int $id): ?Client
    {
        return $this->clientRepository->findById($id);
    }

    public function findAll(): array
    {
        return $this->clientRepository->findAll();
    }
}
