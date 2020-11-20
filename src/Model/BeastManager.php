<?php

namespace App\Model;

class BeastManager extends AbstractManager
{

    const TABLE = 'beast';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function selectBeast(): array
    {
        $request = $this->pdo->query("SELECT * FROM " .self::TABLE. " ORDER BY name");
        return $request->fetchAll();
    }


    public function insertBeast(array $beast): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (name) VALUES (:name)");
        $request->bindValue(':name', ucfirst(strtolower($beast['name'])), \PDO::PARAM_STR);
        return $request->execute();
    }


    public function editBeast(array $beast, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name = :name WHERE " . self::TABLE . ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':name', ucfirst(strtolower($beast['name'])), \PDO::PARAM_STR);
        return $request->execute();
    }


    public function deleteBeast(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }

}
