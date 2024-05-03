<?php

namespace WWCrm\Controllers\Statistics;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatisticsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {

        return $this->view->render('statistics.twig', [
            'title' => 'Статистика',
            'paths' => $this->paths
        ]);
    }

}