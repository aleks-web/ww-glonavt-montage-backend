<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\BookEquipments;

if (!Manager::schema()->hasTable('book_equipments')) {

    Manager::schema()->create('book_equipments', function ($table) {
        $table->id();
		$table->integer('status')->comment('Статус оборудования')->default(BookEquipments::STATUS_ACTIVE); // 1 - без статуса
		$table->string('name', 255)->nullable()->comment('Название оборудования');
        $table->json('field_properties')->nullable()->comment('Характеристики полей оборудования');
        $table->timestamps(); // Дата создания и дата обновления
		
	});

    $fields = [
        [
            'type' => 'input-text',
            'db_field_name' => 'name1',
            'pls' => 'Плейсхолдер 1',
            'name' => 'Имя 1'
        ],
        [
            'type' => 'input-text',
            'db_field_name' => 'name2',
            'pls' => 'Плейсхолдер 2',
            'name' => 'Имя 2'
        ],
        [
            'type' => 'input-text',
            'db_field_name' => 'date',
            'pls' => 'Плейсхолдер date',
            'name' => 'Дата'
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
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
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
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
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
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		],
        [
			'status' => 1,
            'name' => 'Оборудование 3',
            'field_properties' => $fields
		]
	];
	
	
	foreach ($test_arr as $arr) {
		BookEquipments::create($arr);
	}

}