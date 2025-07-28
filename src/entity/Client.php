<?php

namespace App\Entity;

class Client
{
    private ?int $id = null;
    private string $nom;
    private string $prenom;

    public function __construct(string $nom, string $prenom)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
        ];
    }
    public static function toObject(array $data): self
    {
        $client = new self($data['nom'] ?? '', $data['prenom'] ?? '');
        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($client, (int)$data['id']);
        }
        return $client;
    }
}
