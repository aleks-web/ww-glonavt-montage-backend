<?php

namespace WWCrm\Controllers\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookPostsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('books/posts/page.twig', [
            'title' => 'Справочник должностей',
            'paths' => $this->paths,
            'current_user' => $this->WWCurrentUser->getUserObject()
        ]);
    }

}