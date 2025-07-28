<?php

namespace App\Entity;

class Achat
{
    private ?int $id = null;
    private string $reference;
    private string $code;
    private string $date;
    private string $tranche;
    private float $prix;
    private float $nbreKwt;
    private float $montant;
    private string $statut;
    private int $compteurId;
    private int $clientId;

    public function __construct(
        string $reference,
        string $code,
        string $date,
        string $tranche,
        float $prix,
        float $nbreKwt,
        float $montant,
        string $statut,
        int $compteurId,
        int $clientId
    ) {
        $this->reference = $reference;
        $this->code = $code;
        $this->date = $date;
        $this->tranche = $tranche;
        $this->prix = $prix;
        $this->nbreKwt = $nbreKwt;
        $this->montant = $montant;
        $this->statut = $statut;
        $this->compteurId = $compteurId;
        $this->clientId = $clientId;
    }

    public function getId(): ?int { return $this->id; }
    public function getReference(): string { return $this->reference; }
    public function getCode(): string { return $this->code; }
    public function getDate(): string { return $this->date; }
    public function getTranche(): string { return $this->tranche; }
    public function getPrix(): float { return $this->prix; }
    public function getNbreKwt(): float { return $this->nbreKwt; }
    public function getMontant(): float { return $this->montant; }
    public function getStatut(): string { return $this->statut; }
    public function getCompteurId(): int { return $this->compteurId; }
    public function getClientId(): int { return $this->clientId; }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'code' => $this->code,
            'date' => $this->date,
            'tranche' => $this->tranche,
            'prix' => $this->prix,
            'nbreKwt' => $this->nbreKwt,
            'montant' => $this->montant,
            'statut' => $this->statut,
            'compteur_id' => $this->compteurId,
            'client_id' => $this->clientId,
        ];
    }
    public static function toObject(array $data): self
    {
        $achat = new self(
            $data['reference'] ?? '',
            $data['code'] ?? '',
            $data['date'] ?? '',
            $data['tranche'] ?? '',
            (float)($data['prix'] ?? 0),
            (float)($data['nbreKwt'] ?? 0),
            (float)($data['montant'] ?? 0),
            $data['statut'] ?? '',
            (int)($data['compteur_id'] ?? 0),
            (int)($data['client_id'] ?? 0)
        );
        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($achat, (int)$data['id']);
        }
        return $achat;
    }
}
