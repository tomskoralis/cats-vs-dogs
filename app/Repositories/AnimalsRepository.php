<?php

namespace App\Repositories;

use App\Error;
use App\Models\Animal;
use App\Resources\AnimalResource;
use App\Resources\Collections\AnimalResourceCollection;

interface AnimalsRepository
{
    public function getError(): ?Error;

    public function index(): AnimalResourceCollection;

    public function store(Animal $animal): ?AnimalResource;

    public function flush(): void;
}