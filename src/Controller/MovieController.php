<?php

namespace App\Controller;

use App\Model\MovieManager;

/**
 * Class MovieController
 * @package Controller
 */
class MovieController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $moviesManager = new MovieManager();
        $movies = $moviesManager->selectMovie();

        return $this->twig->render('Movie/list.html.twig', [
          'movies' => $movies,
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
      $movieManager = new MovieManager();
      $movie = $movieManager->selectOneById($id);

      return $this->twig->render('Movie/details.html.twig', [
        'movie' => $movie,
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
      $titleError = $pictureError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        if (isset($_POST['modify-data'])) { // data

          if (empty($_POST['title']) || !isset($_POST['title'])) {
            $titleError = "Merci de saisir un titre de Star Wars";
            $isValid = false;
          }

          if ($isValid) {
            $movieManager = new MovieManager();
            $movieManager->editDataMovie($_POST, $id);
            header('Location:/movie/edit/'.$id);
          }

        } else { // picture

          if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {
            $folder = 'movie';

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
                $movieManager = new MovieManager();
                $movieManager->editPictureMovie(['picture' => '/'.$file_destination], $id);
                if (file_exists($filename)) {
                  unlink($filename);
                }
                header('Location:/movie/edit/'.$id);
              } else {
                $pictureError = "Erreur durant l'importation de la photo";
              }
            }
          }
        }
      }

      return $this->twig->render('Movie/edit.html.twig', [
        'titleError'      => $titleError,
        'pictureError'    => $pictureError
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
      $titleError = $pictureError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;

        if (isset($_POST['modify-data'])) { // data

          if (empty($_POST['title']) || !isset($_POST['title'])) {
            $titleError = "Merci de saisir un titre de Star Wars";
            $isValid = false;
          }

          if ($isValid) {
            $movieManager = new MovieManager();
            $movieManager->editDataMovie($_POST, $id);
            header('Location:/movie/edit/'.$id);
          }

        } else { // picture

          if (!empty($_FILES['new-picture']['name']) && isset($_FILES['new-picture'])) {
            $folder = 'movie';

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
                $movieManager = new MovieManager();
                $movieManager->editPictureMovie(['picture' => '/'.$file_destination], $id);
                if (file_exists($filename)) {
                  unlink($filename);
                }
                header('Location:/movie/edit/'.$id);
              } else {
                $pictureError = "Erreur durant l'importation de la photo";
              }
            }
          }
        }
      }

      $movieManager = new MovieManager();
      $movie = $movieManager->selectOneById($id);

      return $this->twig->render('Movie/edit.html.twig', [
        'titleError'      => $titleError,
        'pictureError'    => $pictureError,
        'movie'           => $movie,
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
      $movieManager = new MovieManager();
      $movie = $movieManager->deleteMovie($id);
      header('Location: /movie/list/'.$id);
    }
}
