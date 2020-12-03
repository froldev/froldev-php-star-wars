<?php

namespace App\Model;

class FactionManager extends AbstractManager
{

    const TABLE = 'faction';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectFaction(): array
    {
        $request = $this->pdo->query("SELECT * FROM " .self::TABLE);
        return $request->fetchAll();
    }

    public function insertFaction(array $faction): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (name, picture) VALUES (:name, :picture)");
        $request->bindValue(':name', $faction['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $faction['picture'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function editPictureFaction(array $faction, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " . self::TABLE . " SET picture=:picture WHERE " . self::TABLE . ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':picture', $faction['picture'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function editDataFaction(array $faction, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name=:name WHERE " . self::TABLE . ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':name', $faction['name'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function deleteFaction(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }
}
