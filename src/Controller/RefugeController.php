<?php

namespace App\Controller;

use App\Model\RefugeManager;

/**
 * Class RefugeController
 *
 */
class RefugeController extends AbstractController
{


    /**
     * Display Refuge listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $refugeManager = new RefugeManager();
        $refuges = $refugeManager->selectAll();

        return $this->twig->render('Refuge/index.html.twig', ['refuges' => $refuges]);
    }


    /**
     * Display Refuge informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $refugeManager = new RefugeManager();
        $refuge = $refugeManager->selectOneById($id);

        return $this->twig->render('Refuge/show.html.twig', ['refuge' => $refuge]);
    }


    /**
     * Display Refuge edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $refugeManager = new RefugeManager();
        $refuge = $refugeManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $refuge = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'address' => $_POST['address']
            ];
            $refugeManager->update($refuge);
            header('Location:/refuge/index');
        }

        return $this->twig->render('Refuge/edit.html.twig', ['refuge' => $refuge]);
    }


    /**
     * Display Refuge creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $refugeManager = new RefugeManager();
            $refuge = [
                'name' => $_POST['name'],
                'address' => $_POST['address']
            ];
            $id = $refugeManager->insert($refuge);
            header('Location:/Refuge/show/' . $id);
        }

        return $this->twig->render('Refuge/add.html.twig');
    }


    /**
     * Handle Refuge deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $refugeManager = new RefugeManager();
        $refugeManager->delete($id);
        header('Location:/Refuge/index');
    }
}
