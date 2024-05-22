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
            new \Twig\TwigFunction('short_name', [$this, 'short_name']),
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

    /*
        Возвращает короткое имя основываясь на полученных данных
    */
    public function short_name($name = '', $surname = '', $patronymic = '') : string {
        $name = trim((string) $name);
        $surname = trim((string) $surname);
        $patronymic = trim((string) $patronymic);

        if (empty($surname) && !empty($patronymic)) {
            return ucfirst($name) . ' ' . mb_substr(ucfirst($patronymic), 0, 1, 'utf-8') . '.';
        }

        if (empty($patronymic) && !empty($surname)) {
            return ucfirst($name) . ' ' . mb_substr(ucfirst($surname), 0, 1, 'utf-8') . '.';
        }

        if (empty($patronymic) && empty($surname)) {
            return ucfirst($name);
        }

        return ucfirst($surname) . ' ' . mb_substr(ucfirst($name), 0, 1, 'utf-8') . '. ' . mb_substr(ucfirst($patronymic), 0, 1, 'utf-8') . '.';
    }
}