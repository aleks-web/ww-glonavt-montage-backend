<?php

namespace WWCrm\Others\Twig\Extensions;

class DdTwigExtension extends \Twig\Extension\AbstractExtension
{
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('dd', [$this, 'dd']),
            new \Twig\TwigFunction('dump', [$this, 'dump']),
        ];
    }

    public function dd($dd) {
        dd($dd);
    }

    public function dump($dd) {
        dump($dd);
    }
}