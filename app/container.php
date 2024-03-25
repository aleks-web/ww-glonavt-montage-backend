<?php

namespace WWCrm;

class ServiceContainer {
    public static function getInstance() {
        $builder = new \DI\ContainerBuilder();
        $builder->useAutowiring(false);

        $files = array_merge(
            glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'dependencies' . DIRECTORY_SEPARATOR . '*.php'),
            glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.php')
        );

        $config = array_map(function ($file) {
            return require $file;
        }, $files);


        $builder->addDefinitions(array_merge_recursive(...$config));

        return $builder->build();
    }
}