<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\OrgContactsPersons;

if (!Manager::schema()->hasTable('org_contacts_persons')) {

    Manager::schema()->create('org_contacts_persons', function ($table) {
        $table->id();
        $table->unsignedBigInteger('organization_id')->nullable()->comment('Организация к которой относится контактное лицо');
        $table->string('name', 50)->comment('Имя контактного лица');
        $table->string('surname', 60)->default('')->comment('Фамилия контактного лица');
        $table->string('patronymic', 60)->default('')->comment('Отчество контактного лица');
		$table->string('tel', 15)->nullable()->comment('Телефон контактного лица');
        $table->string('email', 50)->nullable()->comment('Email контактного лица');

        // Внешние ключи:
		$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        
		$table->timestamps(); // Дата создания и дата обновления
	});



	$test_arr = [
		[
            'name' => 'Игорь',
            'surname' => 'Кузнецов',
            'tel' => 89195798871,
            'email' => 'dok.go@yandex.ru',
            'organization_id' => 1
        ],
        [
            'name' => 'Валентин',
            'surname' => 'Кузнецов',
            'tel' => 89195798871,
            'email' => 'dok.go@yandex.ru',
            'organization_id' => 1
        ],
	];


	foreach ($test_arr as $arr) {
		OrgContactsPersons::create($arr);
	}
}