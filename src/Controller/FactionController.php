<?php

namespace App\Controller;

use App\Model\FactionManager;

/**
 * Class FactionController
 * @package Controller
 */
class FactionController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $factionsManager = new FactionManager();
        $factions = $factionsManager->selectFaction();

        return $this->twig->render('Faction/list.html.twig', [
          'factions' => $factions,
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
      $factionManager = new FactionManager();
      $faction = $factionManager->selectOneById($id);

      return $this->twig->render('Faction/details.html.twig', [
        'faction' => $faction,
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
      $nameError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $nameError = "Merci de saisir un nom de faction";
          $isValid = false;
        }
        if ($isValid) {
          if (empty($_POST['picture']) || !isset($_POST['picture'])) {
            $_POST["picture"] = self::EMPTY_PICTURE;
          }
          $factionManager = new FactionManager();
          if ($factionManager->insertFaction($_POST)) {
            header("Location:/faction/list");
          }
        }
      }

      return $this->twig->render('Faction/add.html.twig', [
        'nameError' => $nameError,
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
      $nameError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $nameError = "Merci de saisir un nom de faction";
          $isValid = false;
        }
        if ($isValid) {
          if (empty($_POST['picture']) || !isset($_POST['picture'])) {
            $_POST["picture"] = self::EMPTY_PICTURE;
          }
          $factionManager = new FactionManager();
          $factionManager->editFaction($_POST, $id);
          header('Location:/faction/list/');
        }
      }

      $factionManager = new FactionManager();
      $faction = $factionManager->selectOneById($id);

      return $this->twig->render('Faction/edit.html.twig', [
        'nameError' => $nameError,
        'faction' => $faction,
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
      $factionManager = new FactionManager();
      $faction = $factionManager->deleteFaction($id);
      header('Location: /faction/list/'.$id);
    }
}
