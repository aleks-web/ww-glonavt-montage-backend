<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Organizations;

if (!Manager::schema()->hasTable('organizations')) {

    Manager::schema()->create('organizations', function ($table) {
        $table->id();
        $table->string('name', 255)->nullable()->comment('Имя клиента');
		$table->integer('status')->nullable()->comment('Статус клиента');
		$table->string('inn', 150)->nullable()->comment('ИНН клиента');
		$table->string('director_tel', 50)->nullable()->comment('Телефон руководителя');
		$table->string('director_fio', 50)->nullable()->comment('ФИО руководителя');
		$table->string('email', 50)->nullable()->comment('Email руководителя');
		$table->string('legal_address', 355)->nullable()->comment('Юредический адрес');
		$table->string('actual_address', 355)->nullable()->comment('Фактический адрес');
		$table->string('bank_name', 255)->nullable()->comment('Название банка');
		$table->string('bic', 20)->nullable()->comment('БИК банка');
		$table->string('checking_bill_num', 100)->nullable()->comment('Номер рассчетного счета');
		$table->string('correspondent_bill_num', 100)->nullable()->comment('Номер корреспондентского счета');
		$table->string('okpo', 100)->nullable()->comment('Номер ОКПО');
		$table->string('okato', 100)->nullable()->comment('Номер окато');
		$table->unsignedBigInteger('manager_id')->nullable()->comment('Ответственный менеджер. Id пользователя в системе');

        
		$table->timestamps(); // Дата создания и дата обновления
	});



	$test_arr = [
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		],
		[
			'name' => 'Алексей',
			'inn' => 15
		],
		[
			'name' => 'Василий',
			'inn' => 14
		],
		[
			'name' => 'Мария',
			'inn' => 12
		],
		[
			'name' => 'Георгий',
			'inn' => 10
		],
		[
			'name' => 'Василий',
			'inn' => 10
		],
		[
			'name' => 'Влад',
			'inn' => 107
		]
	];


	foreach ($test_arr as $arr) {
		Organizations::create($arr);
	}
}