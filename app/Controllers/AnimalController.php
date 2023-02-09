<?php

namespace App\Controllers;

use App\Models\Animal;
use App\Repositories\AnimalsRepository;
use App\Responses\Json;

class AnimalController
{
    private AnimalsRepository $animalsRepository;

    public function __construct(AnimalsRepository $animalsRepository)
    {
        $this->animalsRepository = $animalsRepository;
    }

    public function index(): Json
    {
        $animals = $this->animalsRepository->index();

        $error = $this->animalsRepository->getError();
        if ($error) {
            return new Json(json_encode([
                'error' => $error->getMessage()
            ]), 500);
        }
        return new Json($animals->getJson());
    }

    public function store(string $species): Json
    {
        parse_str(file_get_contents('php://input'), $put);

        if (
            !$put['name'] ||
            $species !== 'cat' &&
            $species !== 'dog'
        ) {
            return new Json(json_encode([
                'error' => 'Incorrect input!',
            ]), 400);
        }

        $animal = new Animal(
            $species,
            $put['name'],
        );

        $animal = $this->animalsRepository->store($animal);

        $error = $this->animalsRepository->getError();
        if ($error) {
            return new Json(json_encode([
                'error' => $error->getMessage()
            ]), 500);
        }

        return new Json($animal->getJson(), 201);
    }

    public function delete(): Json
    {
        $this->animalsRepository->flush();

        $error = $this->animalsRepository->getError();
        if ($error) {
            return new Json(json_encode([
                'error' => $error->getMessage()
            ]), 500);
        }

        return $this->index();
    }
}