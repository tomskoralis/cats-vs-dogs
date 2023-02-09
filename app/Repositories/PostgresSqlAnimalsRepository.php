<?php

namespace App\Repositories;

use App\Env;
use App\Error;
use App\Models\Animal;
use App\Resources\AnimalResource;
use App\Resources\Collections\AnimalResourceCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class PostgresSqlAnimalsRepository implements AnimalsRepository
{
    private ?Error $error = null;
    private Connection $connection;

    public function __construct()
    {
        $parameters = [
            'dbname' => Env::get('DB_NAME'),
            'user' => Env::get('DB_USER'),
            'password' => Env::get('DB_PASSWORD'),
            'host' => Env::get('DB_HOST') ?: '127.0.0.1',
            'driver' => Env::get('DB_DRIVER') ?: 'pdo_pgsql',
        ];

        if (Env::areEmpty(['DB_NAME', 'DB_USER'])) {
            $this->error = Env::getError();
            return;
        }

        try {
            $this->connection = DriverManager::getConnection($parameters);
        } catch (Exception $e) {
            $this->error = new Error(
                'repository',
                'Database Exception: ' . $e->getMessage()
            );
        }
    }

    public function getError(): ?Error
    {
        return $this->error;
    }

    public function index(): AnimalResourceCollection
    {
        $animals = new AnimalResourceCollection();
        if ($this->getError()) {
            return $animals;
        }
        try {
            $queryBuilder = $this->connection->createQueryBuilder();
            $queryBuilder
                ->select('*')
                ->from('animals');
            $fetchedAnimals = $queryBuilder->executeQuery()->fetchAllAssociative();
        } catch (Exception $e) {
            $this->error = new Error(
                'repository',
                'Database Exception: ' . $e->getMessage()
            );
            return $animals;
        }
        foreach ($fetchedAnimals as $animal) {
            $animals->add(new AnimalResource(
                $animal['id'],
                $animal['species'],
                $animal['name'],
            ));
        }
        return $animals;
    }

    public function store(Animal $animal): ?AnimalResource
    {
        if ($this->getError()) {
            return null;
        }
        try {
            $queryBuilder = $this->connection->createQueryBuilder();
            $queryBuilder
                ->insert('animals')
                ->values([
                    'species' => '?',
                    'name' => '?',
                ])
                ->setParameter(1, $animal->getSpecies())
                ->setParameter(2, $animal->getName());
            $queryBuilder->executeQuery();

            $queryBuilder = $this->connection->createQueryBuilder();
            $queryBuilder
                ->select('*')
                ->from('animals')
                ->where('id = ?')
                ->setParameter(0, $this->connection->lastInsertId());
            $animal = $queryBuilder->executeQuery()->fetchAssociative();
        } catch (Exception $e) {
            $this->error = new Error(
                'repository',
                'Database Exception: ' . $e->getMessage()
            );
            return null;
        }
        return new AnimalResource(
            $animal['id'],
            $animal['species'],
            $animal['name'],
        );
    }

    public function flush(): void
    {
        if ($this->getError()) {
            return;
        }
        $queryBuilder = $this->connection->createQueryBuilder();
        try {
            $queryBuilder
                ->delete('animals')
                ->executeQuery();
        } catch (Exception $e) {
            $this->error = new Error(
                'repository',
                'Database Exception: ' . $e->getMessage()
            );
        }
    }
}