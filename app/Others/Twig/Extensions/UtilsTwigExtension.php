<?php

namespace WWCrm\Others\Twig\Extensions;

/* 
    ComponentSelectBuilder - Билдер компонента select.twig
*/
use WWCrm\Services\ComponentSelectBuilder;

class UtilsTwigExtension extends \Twig\Extension\AbstractExtension
{
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('dd', [$this, 'dd']),
            new \Twig\TwigFunction('dump', [$this, 'dump']),
            new \Twig\TwigFunction('select', [$this, 'select']),
        ];
    }

    public function dd($dd) {
        !empty($dd) ? dd($dd) : dd('dd без параметров');
    }

    public function dump($dump) {
        !empty($dump) ? dump($dump) : dump('dump без параметров');
    }

    /*
        Рендерит компонент select.twig из проброшенного массива с настройками в аргумент функции select($array)
    */
    public function select($array, $type = null) {
        $builder = new ComponentSelectBuilder();
        $builder->fromArray($array);

        if ($type == 'html') {
            return $builder->toHtml();
        } else if($type == 'array') {
            return $builder->toArray();
        } else {
            return 'Необходимо заполнить второй аргумент функции. html или array';
        }
    }
}