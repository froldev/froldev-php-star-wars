<?php

namespace App\Controller;

use App\Model\PlanetManager;

/**
 * Class PlanetController
 * @package Controller
 */
class PlanetController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $planetsManager = new PlanetManager();
        $planets = $planetsManager->selectPlanet();

        return $this->twig->render('Planet/list.html.twig', [
          'planets' => $planets,
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
      $planetManager = new PlanetManager();
      $planet = $planetManager->selectOneById($id);

      return $this->twig->render('Planet/details.html.twig', [
        'planet' => $planet,
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
      $planetError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $planetError = "Merci de saisir un nom de planète";
          $isValid = false;
        }

        if ($isValid) {
          if (empty($_POST['picture']) || !isset($_POST['picture'])) {
            $_POST["picture"] = self::EMPTY_PICTURE;
          }
          $planetManager = new PlanetManager();
          if ($planetManager->insertPlanet($_POST)) {
            header("Location:/planet/list");
          }
        }
      }

      return $this->twig->render('Planet/add.html.twig', [
        'planetError' => $planetError,
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
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $_POST["picture"] = self::EMPTY_PICTURE;
        }
        $planetManager = new PlanetManager();
        $planetManager->editPlanet($_POST, $id);
        header('Location:/planet/list/');
      }

      $planetManager = new PlanetManager();
      $planet = $planetManager->selectOneById($id);

      return $this->twig->render('Planet/edit.html.twig', [
        'planet' => $planet,
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
      $planetManager = new PlanetManager();
      $planet = $planetManager->deletePlanet($id);
      header('Location: /planet/list/'.$id);
    }
}
