<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Objects;

if (!Manager::schema()->hasTable('objects')) {

    Manager::schema()->create('objects', function ($table) {
        $table->id();
		$table->unsignedBigInteger('organization_id')->nullable()->comment('Организация к которой принадлежит объект');
		$table->integer('status')->comment('Статус объекта')->default(Objects::STATUS_NULL); // 10 - без статуса
		$table->string('brand', 255)->nullable()->comment('Модель объекта');
        $table->string('model', 255)->nullable()->comment('Марка объекта');
        $table->string('gnum', 20)->nullable()->comment('Гос.номер объекта');
        $table->string('vin', 100)->nullable()->comment('Вин.номер');
		$table->year('year')->nullable()->comment('Год выпуска');
		$table->string('color', 20)->nullable()->comment('Цвет');
		$table->string('reg_doc_num', 100)->nullable()->comment('Номер документа о регистрации');
		$table->unsignedBigInteger('user_add_id')->nullable()->comment('Кто добавил');

        $table->timestamps(); // Дата создания и дата обновления

		// Внешние ключи:
		$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
		$table->foreign('user_add_id')->references('id')->on('users')->onDelete('set null'); // Ставим null для user_add_id, если запись удаляется
	});

	$test_arr = [
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345,
			'user_add_id' => 1
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345,
			'user_add_id' => 1
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		],
		[
			'organization_id' => 1,
			'brand' => 'Бренд 1',
			'model' => 'Газ 1',
			'gnum' => 134234,
			'vin' => 124253445,
			'year' => 2024,
			'color' => 'Синий',
			'reg_doc_num' => 3945023528345
		]
	];
	
	
	foreach ($test_arr as $arr) {
		Objects::create($arr);
	}

}