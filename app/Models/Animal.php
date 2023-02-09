<?php

namespace App\Models;

class Animal
{
    private string $species;
    private string $name;

    public function __construct(
        string $species,
        string $name
    )
    {
        $this->species = $species;
        $this->name = $name;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getName(): string
    {
        return $this->name;
    }
}