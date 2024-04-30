<?php

namespace WWCrm\Controllers\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookObjectsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('books/objects/page.twig', [
            'title' => 'Справочник типов объектов',
            'paths' => $this->paths,
            'current_user' => $this->WWCurrentUser->getUserObject()
        ]);
    }

}