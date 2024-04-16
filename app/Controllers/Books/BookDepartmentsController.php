<?php

namespace WWCrm\Controllers\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use WWCrm\Models\BookDepartments;

class BookDepartmentsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('book-departments.twig', [
            'title' => 'Справочник департаментов (отделов)',
            'current_user' => $this->WWCurrentUser->getUserObject()
        ]);
    }

}