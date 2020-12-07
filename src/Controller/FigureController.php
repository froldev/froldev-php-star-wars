<?php

namespace App\Controller;

use App\Model\FactionManager;
use App\Model\FigureManager;
use App\Model\MovieManager;

/**
 * Class FigureController
 * @package Controller
 */
class FigureController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $figuresManager = new FigureManager();
        $figures = $figuresManager->selectFigure();
        
        return $this->twig->render('Figure/list.html.twig', [
          'figures' => $figures,
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
    public function details(int $id)  : string
    {
      $figureManager = new FigureManager();
      $figure = $figureManager->selectFigureJoinMovieAndFaction($id);

      return $this->twig->render('Figure/details.html.twig', [
        'figure' => $figure,
        'noPicture' => self::EMPTY_PICTURE,
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
      $nameError = $bioError = $movieError = $factionError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['name']) || !isset($_POST['name'])) {
          $nameError = "Merci de saisir un nom de personnage";
          $isValid = false;
        }
        if (empty($_POST['bio']) || !isset($_POST['bio'])) {
          $bioError = "Merci de saisir une biographie";
          $isValid = false;
        }
        if (empty($_POST['movie']) || !isset($_POST['movie'])) {
          $movieError = "Merci de sélectionner un film";
          $isValid = false;
        }
        if (empty($_POST['faction']) || !isset($_POST['faction'])) {
          $factionError = "Merci de sélectionner une faction";
          $isValid = false;
        }

        if ($isValid) {
          if (empty($_POST['picture']) || !isset($_POST['picture'])) {
            $_POST["picture"] = self::EMPTY_PICTURE;
          }
          $figureManager = new FigureManager();
          if ($figureManager->insertFigure($_POST)) {
            header("Location:/Figure/list");
          }
        }
      }

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $factionManager = new FactionManager();
      $factions = $factionManager->selectFaction();

      return $this->twig->render('Figure/add.html.twig', [
        'nameError'     => $nameError,
        'bioError'      => $bioError,
        'movieError'    => $movieError,
        'factionError'  => $factionError,
        'movies'        => $movies,
        'factions'      => $factions,
        'noPicture' => self::EMPTY_PICTURE,
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

      $nameError = $bioError = $movieError = $factionError = $pictureError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        if (isset($_POST['modify-data'])) { // data

          if (empty($_POST['name']) || !isset($_POST['name'])) {
            $nameError = "Merci de saisir un nom de personnage";
            $isValid = false;
          }
          if (empty($_POST['bio']) || !isset($_POST['bio'])) {
            $bioError = "Merci de saisir une biographie";
            $isValid = false;
          }
          if (empty($_POST['movie']) || !isset($_POST['movie'])) {
            $movieError = "Merci de sélectionner un film";
            $isValid = false;
          }
          if (empty($_POST['faction']) || !isset($_POST['faction'])) {
            $factionError = "Merci de sélectionner une faction";
            $isValid = false;
          }

          if ($isValid) {
            $figureManager = new FigureManager();
            $figureManager->editDataFigure($_POST, $id);
            header('Location:/Figure/edit/'.$id);
          }

        } else { // picture

          if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {
            $folder = 'figure';

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
                $figureManager = new FigureManager();
                $figureManager->editPictureFigure(['picture' => '/'.$file_destination], $id);
                if (file_exists($filename)) {
                  unlink($filename);
                }
                header('Location:/figure/edit/'.$id);
              } else {
                $pictureError = "Erreur durant l'importation de la photo";
              }
            }
          }
        }
      }

      $figureManager = new FigureManager();
      $figure = $figureManager->selectOneById($id);

      $movieManager = new MovieManager();
      $movies = $movieManager->selectMovie();

      $factionManager = new FactionManager();
      $factions = $factionManager->selectFaction();

      return $this->twig->render('Figure/edit.html.twig', [
        'nameError'     => $nameError,
        'bioError'      => $bioError,
        'movieError'    => $movieError,
        'factionError'  => $factionError,
        'pictureError'  => $pictureError,
        'figure'        => $figure,
        'movies'        => $movies,
        'factions'      => $factions,
        'noPicture'     => self::EMPTY_PICTURE,
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
      $figureManager = new FigureManager();
      $figure = $figureManager->deleteFigure($id);
      header('Location: /Figure/list/'.$id);
    }
}
