<?php


namespace App\Controller;

/**
 * Class CheckpointController
 * @package Controller
 */
class CheckpointController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Checkpoint/index.html.twig');
    }


    /**
     * @param int $error
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function error(int $error)
    {
        return $this->twig->render('Checkpoint/error.html.twig', ['error' => $error]);
    }
}
