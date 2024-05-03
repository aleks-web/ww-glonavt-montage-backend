<?php

namespace WWCrm\Others\Twig\Extensions;

class UtilsTwigExtension extends \Twig\Extension\AbstractExtension
{
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('dd', [$this, 'dd']),
            new \Twig\TwigFunction('dump', [$this, 'dump']),
        ];
    }

    public function dd($dd) {
        !empty($dd) ? dd($dd) : dd('dd без параметров');
    }

    public function dump($dump) {
        !empty($dump) ? dump($dump) : dump('dump без параметров');
    }
}