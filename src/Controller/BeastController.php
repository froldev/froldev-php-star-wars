<?php

namespace App\Controller;

use App\Model\BeastManager;

/**
 * Class BeastController
 * @package Controller
 */
class BeastController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectBeast();

        return $this->twig->render('Beast/list.html.twig', [
          'beasts' => $beasts,
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
      $beastError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $beastError = "Merci de saisir un nom d'espèces";
          $isValid = false;
        }

        if ($isValid) {
          $beastManager = new BeastManager();
          if ($beastManager->insertBeast($_POST)) {
            header("Location:/beast/list");
          }
        }
      }

      return $this->twig->render('Beast/add.html.twig', [
        'beastError' => $beastError,
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
        $beastManager = new BeastManager();
        $beastManager->editBeast($_POST, $id);
        header('Location:/beast/list/');
      }

      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);

      return $this->twig->render('Beast/edit.html.twig', [
        'beast' => $beast,
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
      $beastManager = new BeastManager();
      $beast = $beastManager->deleteBeast($id);
      header('Location: /beast/list/'.$id);
    }
}
