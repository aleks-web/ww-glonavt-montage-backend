<?php

namespace WWCrm\Others\Twig\Extensions;

/*
    Для путей и прочей инфы приложения
*/
class AppTwigExtension extends \Twig\Extension\AbstractExtension {
    
    public function __construct() {
        $this->WWCrmService = \WWCrm\ServiceContainer::getInstance();
        $this->paths = $this->WWCrmService->get('paths');
        $this->routs = $this->WWCrmService->get('routs');
    }
    
    public function getFunctions() {
        return [
            new \Twig\TwigFunction('app', [$this, 'app']),
            new \Twig\TwigFunction('routs', [$this, 'routs']),
        ];
    }

    public function app() {
        return [
            'paths' => $this->paths,
            'routs' => $this->routs
        ];
    }

    public function routs() {
        return $this->routs;
    }
}