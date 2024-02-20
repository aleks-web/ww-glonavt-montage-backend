<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\User;

if (!Manager::schema()->hasTable('users')) {

    Manager::schema()->create('users', function ($table) {
        $table->id();
        $table->string('name', 100);
		$table->string('surname', 150);
        $table->timestamps();
	});



	$test_arr = [
		[
			'name' => 'Алексей',
			'surname' => 'Антропов'
		],
		[
			'name' => 'Василий',
			'surname' => 'Пономарев'
		],
		[
			'name' => 'Мария',
			'surname' => 'Семёновна'
		],
		[
			'name' => 'Георгий',
			'surname' => 'Жуков'
		]
	];


	foreach ($test_arr as $arr) {
		User::create($arr);
	}
}