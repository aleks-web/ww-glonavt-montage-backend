<?php

namespace WWCrm\Others\Twig\Extensions;

/*
    Для путей и прочей инфы приложения
*/
class AppTwigExtension extends \Twig\Extension\AbstractExtension {
    
    public function __construct() {
        $this->WWCrmService = \WWCrm\ServiceContainer::getInstance();
        $this->paths = $this->WWCrmService->get('paths');
    }
    
    public function getFunctions() {
        return [
            new \Twig\TwigFunction('app', [$this, 'app']),
        ];
    }

    public function app() {
        return [
            'paths' => $this->paths
        ];
    }
}