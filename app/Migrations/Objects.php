<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Objects;

if (!Manager::schema()->hasTable('objects')) {

    Manager::schema()->create('objects', function ($table) {
        $table->id();
		$table->unsignedBigInteger('organization_id')->nullable()->comment('Организация к которой принадлежит объект');
		$table->integer('status')->comment('Статус объекта')->default(Objects::STATUS_NULL); // 0 - без статуса
        $table->string('model', 255)->nullable()->comment('Модель');
        $table->string('gnum', 20)->nullable()->comment('Гос.номер объекта');
        $table->string('vin', 100)->nullable()->comment('Вин.номер');
		$table->string('year', 100)->nullable()->comment('Год Выпуска');
		$table->string('color', 20)->nullable()->comment('Цвет');
		$table->string('reg_doc_num', 100)->nullable()->comment('Номер документа о регистрации');
        $table->timestamps(); // Дата создания и дата обновления

		// Внешние ключи:
		$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
	});

	$test_arr = [
		[
			'model' => 'Газ 1',
			'gnum' => 134234,
			'organization_id' => 1
		],
		[
			'model' => 'Ваз 2',
			'gnum' => 13467564,
			'organization_id' => 2
		],
		[
			'model' => 'Ваз 3',
			'gnum' => 13467564,
			'organization_id' => 4
		],
		[
			'model' => 'Ваз 4',
			'gnum' => 13467564,
			'organization_id' => 5
		],
		[
			'model' => 'Ваз 5',
			'gnum' => 13467564,
			'organization_id' => 6
		],
		[
			'model' => 'Ваз 6',
			'gnum' => 13467564,
			'organization_id' => 7
		],
		[
			'model' => 'Газ 1',
			'gnum' => 134234,
			'organization_id' => 1
		],
		[
			'model' => 'Ваз 2',
			'gnum' => 13467564,
			'organization_id' => 2
		],
		[
			'model' => 'Ваз 3',
			'gnum' => 13467564,
			'organization_id' => 4
		],
		[
			'model' => 'Ваз 4',
			'gnum' => 13467564,
			'organization_id' => 5
		],
		[
			'model' => 'Ваз 5',
			'gnum' => 13467564,
			'organization_id' => 6
		],
		[
			'model' => 'Ваз 6',
			'gnum' => 13467564,
			'organization_id' => 7
		]
	];
	
	
	foreach ($test_arr as $arr) {
		Objects::create($arr);
	}

}