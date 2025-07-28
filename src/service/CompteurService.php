<?php

namespace App\Service;

use App\Ripository\CompteurRipository;
use App\Entity\Compteur;

class CompteurService
{
    private $compteurRepository;

    public function __construct()
    {
        $this->compteurRepository = new CompteurRipository();
    }

    public function findByNumero(string $numero): ?Compteur
    {
        return $this->compteurRepository->findByNumero($numero);
    }

    public function findAll(): array
    {
        return $this->compteurRepository->findAll();
    }
}
