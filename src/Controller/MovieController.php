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
      $movieError = null;
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $isValid = true;
        if (empty($_POST['title']) || !isset($_POST['title'])) {
          $movieError = "Merci de saisir un titre de Star Wars";
          $isValid = false;
        }

        if ($isValid) {
          $movieManager = new MovieManager();
          if ($movieManager->insertMovie($_POST)) {
            header("Location:/movie/list");
          }
        }
      }

      return $this->twig->render('Movie/add.html.twig', [
        'movieError' => $movieError,
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
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $movieManager = new MovieManager();
        $movieManager->editMovie($_POST, $id);
        header('Location:/movie/list/');
      }

      $movieManager = new MovieManager();
      $movie = $movieManager->selectOneById($id);

      return $this->twig->render('Movie/edit.html.twig', [
        'movie' => $movie,
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
