<?php

namespace App\Models\Collections;

use App\Collection;
use App\Models\Animal;

class AnimalCollection extends Collection
{
    public function add(Animal $animal): void
    {
        $this->items [] = $animal;
    }
}