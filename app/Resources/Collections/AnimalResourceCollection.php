<?php

namespace App\Resources\Collections;

use App\Collection;
use App\Resources\AnimalResource;

class AnimalResourceCollection extends Collection
{
    public function add(AnimalResource $animalResource): void
    {
        $this->items [] = $animalResource;
    }

    public function getJson(): string
    {
        $animals = [];
        /** @var AnimalResource $animal */
        foreach ($this->getAll() as $animal) {
            $animals [] = $animal->get();
        }
        return json_encode([
            'animals' => $animals,
        ]);
    }
}