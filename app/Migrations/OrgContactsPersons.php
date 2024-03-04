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
        $table->date('birth')->nullable()->comment('День рождения контактного лица');
        $table->string('post', 100)->nullable()->comment('Должность контактного лица');
        $table->unsignedBigInteger('user_add_id')->nullable()->comment('Кто добавил');

        // Внешние ключи:
		$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        $table->foreign('user_add_id')->references('id')->on('users')->onDelete('set null'); // Ставим null для user_add_id, если запись удаляется
        
		$table->timestamps(); // Дата создания и дата обновления
	});

	$test_arr = [
		[
            'name' => 'Игорь',
            'surname' => 'Кузнецов',
            'tel' => 89195798871,
            'email' => 'dok.go@yandex.ru',
            'organization_id' => 1,
            'user_add_id' => 1
        ],
        [
            'name' => 'Валентин',
            'surname' => 'Кузнецов',
            'tel' => 89195798871,
            'email' => 'dok.go@yandex.ru',
            'organization_id' => 1,
            'user_add_id' => 1
        ],
        [
            'name' => 'Николай',
            'surname' => 'Валерьевич',
            'tel' => 89195798871,
            'email' => 'dok.go@yandex.ru',
            'organization_id' => 1,
            'user_add_id' => 1
        ],
	];


	foreach ($test_arr as $arr) {
		OrgContactsPersons::create($arr);
	}
}