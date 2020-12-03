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
      $nameError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $nameError = "Merci de saisir un nom de planète";
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
      $nameError = $pictureError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        
        if (isset($_POST['modify-data'])) { // data

          if (empty($_POST['name']) || !isset($_POST['name'])) {
            $nameError = "Merci de saisir un nom de planète";
            $isValid = false;
          }

          if ($isValid) {
            $planetManager = new PlanetManager();
            $planetManager->editDataPlanet($_POST, $id);
            header('Location:/planet/list/');
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
                $planetManager = new PlanetManager();
                $planetManager->editPicturePlanet(['picture' => '/'.$file_destination], $id);
                if (file_exists($filename)) {
                  unlink($filename);
                }
                header('Location:/planet/edit/'.$id);
              } else {
                $pictureError = "Erreur durant l'importation de la photo";
              }
            }
          }
        }
      }

      $planetManager = new PlanetManager();
      $planet = $planetManager->selectOneById($id);

      return $this->twig->render('Planet/edit.html.twig', [
        'nameError'     => $nameError,
        'pictureError'   => $pictureError,
        'planet'        => $planet,
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
