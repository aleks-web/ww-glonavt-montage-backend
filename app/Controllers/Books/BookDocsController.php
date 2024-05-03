<?php

namespace WWCrm\Controllers\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookDocsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('books/docs/page.twig', [
            'title' => 'Справочник типов документов',
            'paths' => $this->paths,
        ]);
    }

}