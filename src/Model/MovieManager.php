<?php

namespace App\Model;

class MovieManager extends AbstractManager
{

    const TABLE = 'movie';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectMovie(): array
    {
        $request = $this->pdo->query("SELECT * FROM " .self::TABLE. " ORDER BY title");
        return $request->fetchAll();
    }

    public function insertMovie(array $movie): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (title) VALUES (:title)");
        $request->bindValue(':title', $movie['title'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $movie['picture'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function editMovie(array $movie, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " . self::TABLE . " SET title=:title, picture=:picture WHERE " . self::TABLE . ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':title', $movie['title'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $movie['picture'], \PDO::PARAM_STR);
        return $request->execute();
    }

    public function deleteMovie(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }

    public function listOfMovie(): array
    {
        $request = $this->pdo->query("SELECT picture FROM " .self::TABLE);
        return $request->fetchAll();
    }
}
