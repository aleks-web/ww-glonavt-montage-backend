<?php

namespace WWCrm\Others\Twig\Extensions;

class BookTwigExtension extends \Twig\Extension\AbstractExtension {

    public function __construct() {
        $this->WWCrmService = \WWCrm\ServiceContainer::getInstance();
    }

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('get_book_departments', [$this, 'get_book_departments']),
            new \Twig\TwigFunction('get_book_posts', [$this, 'get_book_posts']),
        ];
    }

    public function get_book_departments() {
        $deps = \WWCrm\Models\BookDepartments::all();

        foreach ($deps as $dep) {
            $dep->posts = $dep->posts;
        }

        return $deps;
    }

    public function get_book_posts() {
        $posts = \WWCrm\Models\BookPosts::all();

        foreach ($posts as $post) {
            $post->department = $post->department;
            $post->users = $post->users;
        }

        return $posts;
    }
}