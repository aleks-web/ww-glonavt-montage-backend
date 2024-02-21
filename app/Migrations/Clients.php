<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\Clients as Client;

if (!Manager::schema()->hasTable('clients')) {

    Manager::schema()->create('clients', function ($table) {
        $table->id();
        $table->string('name', 255)->comment('Имя клиента')->nullable();
		$table->unsignedBigInteger('status')->comment('Статус клиента')->nullable();
		$table->string('inn', 150)->comment('ИНН клиента')->nullable();
		$table->string('director_tel', 50)->comment('Телефон руководителя')->nullable();
		$table->string('director_fio', 50)->comment('ФИО руководителя')->nullable();
		$table->string('email', 50)->comment('Email руководителя')->nullable();
		$table->string('legal_address', 355)->comment('Юредический адрес')->nullable();
		$table->string('actual_address', 355)->comment('Фактический адрес')->nullable();
		$table->unsignedBigInteger('bank_id')->comment('Id банка');
		$table->string('bic', 20)->comment('БИК банка')->nullable();
		$table->string('checking_bill_num', 100)->comment('Номер рассчетного счета')->nullable();
		$table->string('correspondent_bill_num', 100)->comment('Номер корреспондентского счета')->nullable();
		$table->string('okpo', 100)->comment('Номер ОКПО')->nullable();
		$table->string('okato', 100)->comment('Номер окато')->nullable();
		$table->unsignedBigInteger('manager_id')->nullable()->comment('Ответственный менеджер. Id пользователя в системе');
        
		$table->timestamps(); // Дата создания и дата обновления
	});



	$test_arr = [
		[
			'name' => 'Алексей',
			'status' => 1
		],
		[
			'name' => 'Василий',
			'status' => 1
		],
		[
			'name' => 'Мария',
			'status' => 1
		],
		[
			'name' => 'Георгий',
			'status' => 1
		]
	];


	foreach ($test_arr as $arr) {
		Client::create($arr);
	}
}