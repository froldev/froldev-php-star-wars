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

  const FOLDER = 'beast';

    public function list(): string
    {
      $beastsManager = new BeastManager();
      $beasts = $beastsManager->selectBeast();

      return $this->twig->render('Beast/list.html.twig', [
        'beasts'    => $beasts,
        'noPicture' => self::EMPTY_PICTURE,
        ]);
    }

    public function details(int $id): string
    {
      $beastsManager = new BeastManager();
      $beast = $beastsManager->selectBeastJoinMovieAndPlanet($id);

      return $this->twig->render('Beast/details.html.twig', [
        'beast'     => $beast,
        'noPicture' => self::EMPTY_PICTURE,
      ]);
    }

    public function add(): string
    {
      $nameError = $sizeError = $areaError = $movieError = $planetError = $pictureError = $file_destination = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        // download picture
        if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {

          $allowed = array('png', 'jpg', 'jpeg', 'gif');
          $file_ext = explode('.', $_FILES['new-picture']['name']);
          $file_ext = strtolower(end($file_ext));

          $file_name_new = uniqid(self::FOLDER.'-', false) . '.' . $file_ext;
          $file_destination = 'assets/images/'. self::FOLDER .'/' . $file_name_new;

          $filename = substr($_FILES['new-picture']['name'], 1);

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
              $_POST['picture'] = "/".$file_destination;
              if (file_exists($filename)) {
                unlink($filename);
              }
            } else {
              $pictureError = "Erreur durant l'importation de la photo";
              $isValid = false;
            }
          }
        }
        
        // save data
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
          $this->updateFolderPictures();
          header('Location:/beast/list');
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
        'noPicture'   => self::EMPTY_PICTURE,
      ]);
    }

    public function edit(int $id): string
    {
      $nameError = $sizeError = $areaError = $movieError = $planetError = $pictureError = $pictureError = $file_destination = null;

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        // download picture
        if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {

          $allowed = array('png', 'jpg', 'jpeg', 'gif');
          $file_ext = explode('.', $_FILES['new-picture']['name']);
          $file_ext = strtolower(end($file_ext));

          $file_name_new = uniqid( self::FOLDER .'-', false) . '.' . $file_ext;
          $file_destination = 'assets/images/'. self::FOLDER .'/' . $file_name_new;

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
              $_POST['picture'] = "/".$file_destination;
              if (file_exists($filename)) {
                unlink($filename);
              }
            } else {
              $pictureError = "Erreur durant l'importation de la photo";
              $isValid = false;
            }
          }
        }
        
        // save data
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
          $this->updateFolderPictures();
          header('Location:/beast/list');
        }
      }

      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $planetManager = new PlanetManager();
      $planets = $planetManager->selectPlanet();

      $pictureName = (str_replace('/assets/images/'. self::FOLDER .'/', '', $beast['picture']));

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
        'pictureName'   => $pictureName,
      ]);
    }

    /**
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function delete(int $id): void
    {
      $beastManager = new BeastManager();
      $beast = $beastManager->deleteBeast($id);
      $this->updateFolderPictures();
      header('Location: /beast/list/'.$id);
    }

    /**
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updateFolderPictures(): void
    {
      $path = "/assets/images/". self::FOLDER ."/";
      $beastManager = new BeastManager(); // pictures in bdd
      $pictures = $beastManager->listOfBeast();
      foreach ($pictures as $key=>$value)
      {
        $pictureTable[$key] = trim(current(str_replace($path, " ", $value)));
      }
      $dir = substr($path, 1);; // pictures in folder
      $scan = array_diff(scandir($dir), array('..', '.'));

      $diff = array_diff($scan, $pictureTable); // differences
      foreach ($diff as $filename){ // delete pictures in folder but not in bdd
        if (file_exists(substr($path, 1).$filename)) {
          unlink(substr($path, 1).$filename);
        }
      }
    }
}
