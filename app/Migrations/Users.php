<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Users;

if (!Manager::schema()->hasTable('users')) {

    Manager::schema()->create('users', function ($table) {
        $table->id();
        $table->string('name', 50)->nullable()->comment('Имя пользователя');
        $table->string('surname', 60)->nullable()->comment('Фамилия пользователя');
        $table->string('patronymic', 60)->nullable()->comment('Отчество пользователя');
		$table->string('tel', 20)->nullable()->comment('Телефон пользователя');
		$table->string('email', 50)->nullable()->comment('Email пользователя');
        $table->date('birth')->nullable()->comment('День рождения пользователя');
	});

	$test_arr = [
		[
			'name' => 'Алексей',
			'surname' => 'Антропов',
            'patronymic' => 'Андреевич',
			'tel' => 89195798871,
            'email' => 'dok.go@yandex.ru'
		]
	];
	
	
	foreach ($test_arr as $arr) {
		Users::create($arr);
	}

}