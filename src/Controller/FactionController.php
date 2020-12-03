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
      $nameError = $pictureError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        if (isset($_POST['modify-data'])) { // data

          if (empty($_POST['name']) || !isset($_POST['name'])) {
            $nameError = "Merci de saisir un nom de faction";
            $isValid = false;
          }
          if ($isValid) {
            if (empty($_POST['picture']) || !isset($_POST['picture'])) {
              $_POST["picture"] = self::EMPTY_PICTURE;
            }
            $factionManager = new FactionManager();
            $factionManager->editdataFaction($_POST, $id);
            header('Location:/faction/edit/'.$id);
          }

        } else { // picture

          $folder = 'faction';

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
                $factionManager = new FactionManager();
                $factionManager->editPictureFaction(['picture' => '/'.$file_destination], $id);
                if (file_exists($filename)) {
                  unlink($filename);
                }
                header('Location:/faction/edit/'.$id);
              } else {
                $pictureError = "Erreur durant l'importation de la photo";
              }
            }

        }
      }

      $factionManager = new FactionManager();
      $faction = $factionManager->selectOneById($id);

      return $this->twig->render('Faction/edit.html.twig', [
        'nameError' => $nameError,
        'pictureError'   => $pictureError,
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
