<?php

namespace App\Controller;

use App\Model\CharacterManager;

/**
 * Class CharacterController
 * @package Controller
 */
class CharacterController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $charactersManager = new CharacterManager();
        $characters = $charactersManager->selectCharacter();
        
        return $this->twig->render('Character/list.html.twig', [
          'characters' => $characters,
          ]);
    }


    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id)  : string
    {
      $CharacterManager = new CharacterManager();
      $character = $CharacterManager->selectOneById($id);
      return $this->twig->render('Character/details.html.twig', [
        'character' => $character,
      ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add() : string
    {
      $characterError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $characterError = "Merci de saisir un nom de personnages";
          $isValid = false;
        }
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $characterError = "Merci de saisir une url valide pour l'image";
          $isValid = false;
        }
        if (empty($_POST['bio']) || !isset($_POST['bio'])) {
          $characterError = "Merci de saisir une biographie";
          $isValid = false;
        }
        if (empty($_POST['id_movie']) || !isset($_POST['id_movie'])) {
          $characterError = "Merci de sélectionner un film";
          $isValid = false;
        }
        if (empty($_POST['id_beast']) || !isset($_POST['id_beast'])) {
          $characterError = "Merci de sélectionner une espèce";
          $isValid = false;
        }
        if (empty($_POST['id_faction']) || !isset($_POST['id_faction'])) {
          $characterError = "Merci de sélectionner une faction";
          $isValid = false;
        }


        if ($isValid) {
          $CharacterManager = new CharacterManager();
          if ($CharacterManager->insertCharacter($_POST)) {
            header("Location:/Character/list");
          }
        }
      }

      return $this->twig->render('Character/add.html.twig', [
        'characterError' => $characterError,
      ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id) : string
    {
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $CharacterManager = new CharacterManager();
        $CharacterManager->editCharacter($_POST, $id);
        header('Location:/Character/list/');
      }

      $CharacterManager = new CharacterManager();
      $character = $CharacterManager->selectOneById($id);

      return $this->twig->render('Character/edit.html.twig', [
        'character' => $character,
      ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function delete(int $id): void
    {
      $CharacterManager = new CharacterManager();
      $character = $CharacterManager->deleteCharacter($id);
      header('Location: /Character/list/'.$id);
    }
}
