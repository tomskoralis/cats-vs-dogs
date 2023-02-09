<?php

namespace App\Resources;

use App\Models\Animal;

class AnimalResource extends Animal
{
    private int $id;

    public function __construct(
        int    $id,
        string $species,
        string $name
    )
    {
        parent::__construct($species, $name);
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function get(): array
    {
        return [
            'id' => $this->getId(),
            'species' => $this->getSpecies(),
            'name' => $this->getName(),
        ];
    }

    public function getJson(): string
    {
        return json_encode([
            'animal' => $this->get(),
        ]);
    }
}