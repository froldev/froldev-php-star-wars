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

    public function selectBeastJoinMovieAndPlanet(int $id): array
    {
        $request = $this->pdo->prepare("SELECT
        b.id, b.name, b.picture, b.size, b.area, p.name AS planet, m.title AS movie 
        FROM ".self::TABLE." b
        JOIN planet p ON b.id_planet = p.id
        JOIN movie m ON b.id_movie = m.id
        WHERE b.id=:id"
        );
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetch();
    }

    public function insertBeast(array $beast): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. 
        " (name, picture, size, area, id_movie, id_planet) 
        VALUES (:name, :picture, :size, :area, :movie, :planet)");
        $request->bindValue(':name', $beast['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $beast['picture'], \PDO::PARAM_STR);
        $request->bindValue(':size', $beast['size'], \PDO::PARAM_STR);
        $request->bindValue(':area', $beast['area'], \PDO::PARAM_STR);
        $request->bindValue(':movie', $beast['movie'], \PDO::PARAM_INT);
        $request->bindValue(':planet', $beast['planet'], \PDO::PARAM_INT);
        return $request->execute();
    }

    public function editBeast(array $beast, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " .self::TABLE. 
        " SET name =:name, picture=:picture, size=:size, area=:area, id_movie=:movie, id_planet=:planet 
        WHERE " .self::TABLE. ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':name', $beast['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $beast['picture'], \PDO::PARAM_STR);
        $request->bindValue(':size', $beast['size'], \PDO::PARAM_STR);
        $request->bindValue(':area', $beast['area'], \PDO::PARAM_STR);
        $request->bindValue(':movie', $beast['movie'], \PDO::PARAM_INT);
        $request->bindValue(':planet', $beast['planet'], \PDO::PARAM_INT);
        return $request->execute();
    }

    public function deleteBeast(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }

    public function listOfBeast(): array
    {
        $request = $this->pdo->query("SELECT picture FROM " .self::TABLE);
        return $request->fetchAll();
    }
}
