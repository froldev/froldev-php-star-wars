<?php

namespace App\Controller;

use App\Model\MovieManager;

/**
 * Class MovieController
 * @package Controller
 */
class MovieController extends AbstractController
{

  const FOLDER = 'movie';

  /**
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function list(): string
  {
    $moviesManager = new MovieManager();
    $movies = $moviesManager->selectMovie();

    return $this->twig->render('Movie/list.html.twig', [
      'movies'    => $movies,
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
    $movieManager = new MovieManager();
    $movie = $movieManager->selectOneById($id);

    return $this->twig->render('Movie/details.html.twig', [
      'movie'     => $movie,
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
    $titleError = $pictureError = $file_destination = null;
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
      if (empty($_POST['title']) || !isset($_POST['title'])) {
        $titleError = "Merci de saisir un titre de Star Wars";
        $isValid = false;
      }

      if ($isValid) {
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $_POST["picture"] = self::EMPTY_PICTURE;
        }
        $movieManager = new MovieManager();
        $movieManager->insertMovie($_POST);
        $this->updateFolderPictures();
        header('Location:/movie/list');
      }
    }

    return $this->twig->render('Movie/edit.html.twig', [
      'titleError'      => $titleError,
      'pictureError'    => $pictureError,
      'noPicture'       => self::EMPTY_PICTURE,
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
    $titleError =  $pictureError = $file_destination = null;

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
      if (empty($_POST['title']) || !isset($_POST['title'])) {
        $titleError = "Merci de saisir un titre de Star Wars";
        $isValid = false;
      }

      if ($isValid) {
        if (empty($_POST['picture']) || !isset($_POST['picture'])) {
          $_POST["picture"] = self::EMPTY_PICTURE;
        }
        $movieManager = new MovieManager();
        $movieManager->editMovie($_POST, $id);
        $this->updateFolderPictures();
        header('Location:/movie/list');
      }
    }

    $movieManager = new MovieManager();
    $movie = $movieManager->selectOneById($id);

    $pictureName = (str_replace('/assets/images/'. self::FOLDER .'/', '', $movie['picture']));

    return $this->twig->render('Movie/edit.html.twig', [
      'titleError'      => $titleError,
      'pictureError'    => $pictureError,
      'movie'           => $movie,
      'noPicture'       => self::EMPTY_PICTURE,
      'pictureName'     => $pictureName,
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
    $movieManager = new MovieManager();
    $movie = $movieManager->deleteMovie($id);
    $this->updateFolderPictures();
    header('Location: /movie/list/'.$id);
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
    $movieManager = new MovieManager(); // pictures in bdd
    $pictures = $movieManager->listOfMovie();
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
