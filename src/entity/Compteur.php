<?php

namespace App\Entity;

class Compteur
{
    private ?int $id = null;
    private string $numero;
    private int $clientId;

    public function __construct(string $numero, int $clientId)
    {
        $this->numero = $numero;
        $this->clientId = $clientId;
    }

    public function getId(): ?int { return $this->id; }
    public function getNumero(): string { return $this->numero; }
    public function getClientId(): int { return $this->clientId; }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'client_id' => $this->clientId,
        ];
    }
    public static function toObject(array $data): self
    {
        $compteur = new self($data['numero'] ?? '', (int)($data['client_id'] ?? 0));
        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($compteur, (int)$data['id']);
        }
        return $compteur;
    }
}
