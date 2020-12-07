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
          'noPicture' => self::EMPTY_PICTURE,
          ]);
    }

    public function details(int $id)  : string
    {
      $beastsManager = new BeastManager();
      $beast = $beastsManager->selectBeastJoinMovieAndPlanet($id);
      return $this->twig->render('Beast/details.html.twig', [
        'beast' => $beast,
        'noPicture' => self::EMPTY_PICTURE,
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
        'noPicture' => self::EMPTY_PICTURE,
      ]);
    }

    public function edit(int $id) : string
    {
      $nameError = $sizeError = $areaError = $movieError = $planetError = $pictureError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        if (isset($_POST['modify-data'])) { // data

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
            $beastManager = new BeastManager();
          $beastManager->editDataBeast($_POST, $id);
          header('Location:/beast/edit/'.$id);
          }

        } else { // picture

          if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {
            $folder = 'beast';

            $allowed = array('png', 'jpg', 'jpeg', 'gif');
            $file_ext = explode('.', $_FILES['new-picture']['name']);
            $file_ext = strtolower(end($file_ext));

            $file_name_new = uniqid($folder.'-', false) . '.' . $file_ext;
            $file_destination = 'assets/images/'.$folder.'/' . $file_name_new;

            $filename = substr($_POST['picture'], 1);

            if ($_FILES['new-picture']['size'] > 2097152) {
              $pictureError = "La photo ne doit pas dépasser 2 Mo";
              $isValid = false;
            }
            if(!in_array($file_ext, $allowed)) {
              $pictureError = "La photo doit être au format jpg, jpeg, gif ou png";
              $isValid = false;
            }

            if ($isValid) {
              if (move_uploaded_file($_FILES['new-picture']['tmp_name'], $file_destination)) {
                $beastManager = new BeastManager();
                $beastManager->editPictureBeast(['picture' => '/'.$file_destination], $id);
                if (file_exists($filename)) {
                  unlink($filename);
                }
                header('Location:/beast/edit/'.$id);
              } else {
                $pictureError = "Erreur durant l'importation de la photo";
              }
            }
          }
        }
      }

      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $planetManager = new PlanetManager();
      $planets = $planetManager->selectPlanet();

      return $this->twig->render('Beast/edit.html.twig', [
        'nameError'     => $nameError,
        'sizeError'     => $sizeError,
        'areaError'     => $areaError,
        'movieError'    => $movieError,
        'planetError'   => $planetError,
        'pictureError'  => $pictureError,
        'beast'         => $beast,
        'movies'        => $movies,
        'planets'       => $planets,
        'noPicture'     => self::EMPTY_PICTURE,
      ]);
    }


    public function delete(int $id): void
    {
      $beastManager = new BeastManager();
      $beast = $beastManager->deleteBeast($id);
      header('Location: /beast/list/'.$id);
    }
}
