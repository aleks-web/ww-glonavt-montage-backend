<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Objects;

if (!Manager::schema()->hasTable('objects')) {

    Manager::schema()->create('objects', function ($table) {
        $table->id();
        $table->string('name', 255)->nullable()->comment('Имя клиента');
        $table->string('gnum', 20)->nullable()->comment('Гос.номер объекта');
        $table->string('vin', 100)->nullable()->comment('Вин.номер');
		
        
        $table->timestamps(); // Дата создания и дата обновления
	});



	$test_arr = [
		[
			'name' => 'Тест 1',
			'gnum' => 134234
		],
		[
			'name' => 'Тест 2',
			'gnum' => 13467564
		]
	];


	foreach ($test_arr as $arr) {
		Objects::create($arr);
	}
}