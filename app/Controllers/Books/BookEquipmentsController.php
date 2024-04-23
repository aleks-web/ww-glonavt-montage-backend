<?php

namespace WWCrm\Controllers\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookEquipmentsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('books/equipments/page.twig', [
            'title' => 'Справочник оборудования',
            'paths' => $this->paths,
            'current_user' => $this->WWCurrentUser->getUserObject()
        ]);
    }

}