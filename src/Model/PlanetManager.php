<?php

namespace App\Model;

class PlanetManager extends AbstractManager
{

    const TABLE = 'planet';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectPlanet(): array
    {
        $request = $this->pdo->query("SELECT * FROM " .self::TABLE. " ORDER BY name");
        return $request->fetchAll();
    }

    public function insertPlanet(array $planet): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (name, picture) VALUES (:name, :picture)");
        $request->bindValue(':name', $planet['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $planet['picture'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function editPlanet(array $planet, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name=:name, picture=:picture WHERE " . self::TABLE . ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':name', $planet['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $planet['picture'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function deletePlanet(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }
}
