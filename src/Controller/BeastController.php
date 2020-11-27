<?php

namespace App\Controller;

use App\Model\BeastManager;
use App\Model\MovieManager;
use App\Model\PlanetManager;

/**
 * Class BeastController
 * @package Controller
 */
class BeastController extends AbstractController
{
    public function list() : string
    {
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectBeast();

        return $this->twig->render('Beast/list.html.twig', [
          'beasts' => $beasts,
          ]);
    }

    public function details(int $id)  : string
    {
      $beastsManager = new BeastManager();
      $beast = $beastsManager->selectBeastJoinMovieAndPlanet($id);
      return $this->twig->render('Beast/details.html.twig', [
        'beast' => $beast,
      ]);
    }

    public function add() : string
    {
      $nameError = $sizeError = $areaError = $movieError = $planetError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $nameError = "Merci de saisir un nom";
          $isValid = false;
        }
        if (empty($_POST['size']) || !isset($_POST['size'])) {
          $sizeError = "Merci de saisir une taille en mètres";
          $isValid = false;
        }
        if (empty($_POST['area']) || !isset($_POST['area'])) {
          $areaError = "Merci de saisir une surface";
          $isValid = false;
        }
        if (empty($_POST['movie']) || !isset($_POST['movie'])) {
          $movieError = "Merci de sélectionner le film de la première apparition";
          $isValid = false;
        }
        if (empty($_POST['planet']) || !isset($_POST['planet'])) {
          $planetError = "Merci de sélectionner une planète";
          $isValid = false;
        }

        if ($isValid) {
          if (empty($_POST['picture']) || !isset($_POST['picture'])) {
            $_POST["picture"] = self::EMPTY_PICTURE;
          }
          $beastManager = new BeastManager();
          if ($beastManager->insertBeast($_POST)) {
            header("Location:/beast/list");
          }
        }
      }

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $planetManager = new PlanetManager();
      $planets = $planetManager->selectPlanet();

      return $this->twig->render('Beast/add.html.twig', [
        'nameError'   => $nameError,
        'sizeError'   => $sizeError,
        'areaError'   => $areaError,
        'movieError'  => $movieError,
        'planetError' => $planetError,
        'movies'      => $movies,
        'planets'     => $planets,
      ]);
    }

    public function edit(int $id) : string
    {
      $nameError = $sizeError = $areaError = $movieError = $planetError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $nameError = "Merci de saisir un nom";
          $isValid = false;
        }
        if (empty($_POST['size']) || !isset($_POST['size'])) {
          $sizeError = "Merci de saisir une taille en mètres";
          $isValid = false;
        }
        if (empty($_POST['area']) || !isset($_POST['area'])) {
          $areaError = "Merci de saisir une surface";
          $isValid = false;
        }
        if (empty($_POST['movie']) || !isset($_POST['movie'])) {
          $movieError = "Merci de sélectionner le film de la première apparition";
          $isValid = false;
        }
        if (empty($_POST['planet']) || !isset($_POST['planet'])) {
          $planetError = "Merci de sélectionner une planète";
          $isValid = false;
        }

        if ($isValid) {
          if (empty($_POST['picture']) || !isset($_POST['picture'])) {
            $_POST["picture"] = self::EMPTY_PICTURE;
          }
          $beastManager = new BeastManager();
          $beastManager->editBeast($_POST, $id);
          header('Location:/beast/list/');
        }
      }

      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $planetManager = new PlanetManager();
      $planets = $planetManager->selectPlanet();

      return $this->twig->render('Beast/edit.html.twig', [
        'nameError'   => $nameError,
        'sizeError'   => $sizeError,
        'areaError'   => $areaError,
        'movieError'  => $movieError,
        'planetError' => $planetError,
        'beast'       => $beast,
        'movies'      => $movies,
        'planets'     => $planets,
      ]);
    }


    public function delete(int $id): void
    {
      $beastManager = new BeastManager();
      $beast = $beastManager->deleteBeast($id);
      header('Location: /beast/list/'.$id);
    }
}
