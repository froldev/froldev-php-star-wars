<?php

namespace App\Controller;

use App\Model\PlanetManager;

/**
 * Class PlanetController
 * @package Controller
 */
class PlanetController extends AbstractController
{

  const FOLDER = 'planet';

  /**
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function list(): string
  {
    $planetsManager = new PlanetManager();
    $planets = $planetsManager->selectPlanet();

    return $this->twig->render('Planet/list.html.twig', [
      'planets'   => $planets,
      'noPicture' => self::EMPTY_PICTURE,
    ]);
  }

    /**
   * @param int $id
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function details(int $id): string
  {
    $planetManager = new PlanetManager();
    $planet = $planetManager->selectOneById($id);

    return $this->twig->render('Planet/details.html.twig', [
      'planet'    => $planet,
      'noPicture' => self::EMPTY_PICTURE,
    ]);
  }

  /**
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function add(): string
  {
    $nameError = $pictureError = $file_destination = null;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $isValid = true;

      // download picture
      if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {
        $allowed = array('png', 'jpg', 'jpeg', 'gif');
        $file_ext = explode('.', $_FILES['new-picture']['name']);
        $file_ext = strtolower(end($file_ext));

        $file_name_new = uniqid( self::FOLDER .'-', false) . '.' . $file_ext;
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
        $nameError = "Merci de saisir un nom de planète";
        $isValid = false;
      }

      if ($isValid) {
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $_POST["picture"] = self::EMPTY_PICTURE;
        }
        $planetManager = new PlanetManager();
        $planetManager->insertPlanet($_POST);
        $this->updateFolderPictures();
        header('Location:/planet/list/');
      }
    }

    return $this->twig->render('Planet/edit.html.twig', [
      'nameError'     => $nameError,
      'pictureError'  => $pictureError,
      'noPicture'     => self::EMPTY_PICTURE,
    ]);
  }

  /**
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function edit(int $id): string
  {
    $nameError = $pictureError = $file_destination = null;

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
        $nameError = "Merci de saisir un nom de planète";
        $isValid = false;
      }

      if ($isValid) {
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $_POST["picture"] = self::EMPTY_PICTURE;
        }
        $planetManager = new PlanetManager();
        $planetManager->editPlanet($_POST, $id);
        $this->updateFolderPictures();
        header('Location:/planet/list');
      }
    }

    $planetManager = new PlanetManager();
    $planet = $planetManager->selectOneById($id);

    $pictureName = (str_replace('/assets/images/'. self::FOLDER .'/', '', $planet['picture']));

    return $this->twig->render('Planet/edit.html.twig', [
      'nameError'     => $nameError,
      'pictureError'  => $pictureError,
      'planet'        => $planet,
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
    $planetManager = new PlanetManager();
    $planet = $planetManager->deletePlanet($id);
    $this->updateFolderPictures();
    header('Location: /planet/list/'.$id);
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
    $planetManager = new PlanetManager(); // pictures in bdd
    $pictures = $planetManager->listOfPlanet();
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
