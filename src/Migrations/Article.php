<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Article;

if (!Manager::schema()->hasTable('articles')) {

    Manager::schema()->create('articles', function ($table) {
        $table->id();
        $table->string('title', 300);
		$table->string('description', 500);
		$table->unsignedBigInteger('user_id');
        $table->timestamps();

		$table->foreign('user_id')->references('id')->on('users');

	});



	$test_arr = [
		[
			'title' => 'Статья 1',
			'description' => 'Описание статьи 1',
			'user_id' => 1
		],
		[
			'title' => 'Статья 2',
			'description' => 'Описание статьи 2',
			'user_id' => 1
		],
		[
			'title' => 'Статья 3',
			'description' => 'Описание статьи 3',
			'user_id' => 1
		],
		[
			'title' => 'Статья 4',
			'description' => 'Описание статьи 4',
			'user_id' => 2
		],
		[
			'title' => 'Статья 5',
			'description' => 'Описание статьи 5',
			'user_id' => 2
		],
		[
			'title' => 'Статья 6',
			'description' => 'Описание статьи 6',
			'user_id' => 3
		]
	];


	foreach ($test_arr as $arr) {
		Article::create($arr);
	}
}