<?php

namespace App\Model;

class CharacterManager extends AbstractManager
{

    const TABLE = 'character';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function selectCharacter(): array
    {
        $request = $this->pdo->query("SELECT * FROM " .self::TABLE. " ORDER BY name");
        return $request->fetchAll();
    }


    public function selectCharacterJoinMovieAndFaction(int $id): array
    {
        $request = $this->pdo->query(
            "SELECT * FROM character WHERE id=:id"
        );
        $request->bindValue('id', $id, \PDO::PARAM_INT);
        $request->execute();

        return $request->fetch();
    }


    public function insertCharacter(array $character): bool
    {
        $request = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (name, picture, bio, id_movie, id_faction) VALUES (:name, :picture, :bio, :idMovie, :idFaction)");
        $request->bindValue(':name', ucfirst(strtolower($character['name'])), \PDO::PARAM_STR);
        return $request->execute();
    }


    public function editCharacter(array $character, int $id): bool
    {
        $request = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name = :name WHERE " . self::TABLE . ".id=:id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':name', ucfirst(strtolower($character['name'])), \PDO::PARAM_STR);
        return $request->execute();
    }


    public function deleteCharacter(int $id): void
    {
        $request = $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $request->bindValue(":id", $id, \PDO::PARAM_INT);
        $request->execute();
    }

}
