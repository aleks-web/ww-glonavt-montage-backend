<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\BookEquipment;

if (!Manager::schema()->hasTable('book_equipment')) {

    Manager::schema()->create('book_equipment', function ($table) {
        $table->id();
		$table->integer('status')->comment('Статус оборудования')->default(BookEquipment::STATUS_ACTIVE); // 1 - без статуса
		$table->string('name', 255)->nullable()->comment('Название оборудования');
        $table->json('field_properties', 255)->nullable()->comment('Характеристики полей оборудования');

        $table->timestamps(); // Дата создания и дата обновления

		// Внешние ключи:
		
	});

    $fields = [
        'name1' => [
            'type' => 'input-text',
            'db_field_name' => 'name1',
            'pls' => 'Плейсхолдер 1'
        ],
        'name2' => [
            'type' => 'input-text',
            'db_field_name' => 'name2',
            'pls' => 'Плейсхолдер 2'
        ],
        'date' => [
            'type' => 'input-text',
            'db_field_name' => 'date',
            'pls' => 'Плейсхолдер date'
        ]
    ];

    $fields = json_encode($fields);

	$test_arr = [
		[
			'status' => 1,
            'name' => 'Оборудование 1',
            'field_properties' => $fields
        ],
        [
			'status' => 1,
            'name' => 'Оборудование 2',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		]
	];
	
	
	foreach ($test_arr as $arr) {
		BookEquipment::create($arr);
	}

}