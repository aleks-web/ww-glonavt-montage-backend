<?php

namespace WWCrm\Others\Twig\Extensions;

/*
    Для путей и прочей инфы приложения
*/
class AppTwigExtension extends \Twig\Extension\AbstractExtension {
    
    public function __construct() {
        
    }
    
    public function getFunctions() {
        return [
            new \Twig\TwigFunction('tt', [$this, 'tt']),
        ];
    }

    public function tt() {
        return 'tt';
    }
}