<?php

namespace WWCrm\Others\Twig\Extensions;

class CurrentUserTwigExtension extends \Twig\Extension\AbstractExtension {
    
    protected $WWCrmService;
    protected $WWCurrentUser;

    public function __construct() {
        $this->WWCrmService = \WWCrm\ServiceContainer::getInstance();
        $this->WWCurrentUser = $this->WWCrmService->get('CurrentUser');
    }
    
    public function getFunctions() {
        return [
            new \Twig\TwigFunction('current_user', [$this, 'current_user']),
        ];
    }

    public function current_user() {
        return $this->WWCurrentUser->getUserObject();
    }
}