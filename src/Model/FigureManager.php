<?php

namespace App\Model;

class FigureManager extends AbstractManager
{

    const TABLE = 'figure';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function selectFigure(): array
    {
        $request = $this->pdo->query("SELECT * FROM ".self::TABLE." ORDER BY name");
        return $request->fetchAll();
    }


    public function selectFigureJoinMovieAndFaction(int $id): array
    {
        $request = $this->pdo->prepare("SELECT 
        f.id, f.name, f.picture, f.bio, m.title AS movie, faction.name AS faction 
        FROM ".self::TABLE." f 
        JOIN movie m ON f.id_movie = m.id 
        JOIN faction ON f.id_faction = faction.id 
        WHERE f.id=:id");
        $request->bindValue('id', $id, \PDO::PARAM_INT);
        $request->execute();

        return $request->fetch();
    }


    public function insertFigure(array $figure): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. 
        " (name, picture, bio, id_movie, id_faction) 
        VALUES (:name, :picture, :bio, :movie, :faction)");
        $request->bindValue(':name', $figure['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $figure['picture'], \PDO::PARAM_STR);
        $request->bindValue(':bio', $figure['bio'], \PDO::PARAM_STR);
        $request->bindValue(':movie', $figure['movie'], \PDO::PARAM_INT);
        $request->bindValue(':faction', $figure['faction'], \PDO::PARAM_INT);
        return $request->execute();
    }


    public function editFigure(array $figure, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE ".self::TABLE." 
        SET name=:name, picture=:picture, bio=:bio, id_movie=:movie, id_faction=:faction 
        WHERE ".self::TABLE.".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':name', $figure['name'], \PDO::PARAM_STR);
        $request->bindValue(':picture', $figure['picture'], \PDO::PARAM_STR);
        $request->bindValue(':bio', $figure['bio'], \PDO::PARAM_STR);
        $request->bindValue(':movie', $figure['movie'], \PDO::PARAM_INT);
        $request->bindValue(':faction', $figure['faction'], \PDO::PARAM_INT);
        return $request->execute();
    }


    public function deleteFigure(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }

}
