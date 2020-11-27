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
      $beastError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $beastError = "Merci de saisir un nom de race ou d'espèce";
          $isValid = false;
        }
        if (empty($_POST['bio']) || !isset($_POST['bio'])) {
          $beastError = "Merci de saisir une biographie";
          $isValid = false;
        }
        if (empty($_POST['id_movie']) || !isset($_POST['id_movie'])) {
          $beastError = "Merci de saisir le fim de la première apparition";
          $isValid = false;
        }
        if (empty($_POST['id_planet']) || !isset($_POST['id_planet'])) {
          $beastError = "Merci de saisir une planète";
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
        'beastError'  => $beastError,
        'movies'      => $movies,
        'planets'     => $planets,
      ]);
    }

    public function edit(int $id) : string
    {
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $_POST["picture"] = self::EMPTY_PICTURE;
        }
        $beastManager = new BeastManager();
        $beastManager->editBeast($_POST, $id);
        header('Location:/beast/list/');
      }

      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $planetManager = new PlanetManager();
      $planets = $planetManager->selectPlanet();

      return $this->twig->render('Beast/edit.html.twig', [
        'beast'   => $beast,
        'movies'  => $movies,
        'planets' => $planets,
      ]);
    }


    public function delete(int $id): void
    {
      $beastManager = new BeastManager();
      $beast = $beastManager->deleteBeast($id);
      header('Location: /beast/list/'.$id);
    }
}
