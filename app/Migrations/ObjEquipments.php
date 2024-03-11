<?php

use Illuminate\Database\Capsule\Manager;
use WWCrm\Models\ObjEquipments;

if (!Manager::schema()->hasTable('obj_equipments')) {

    Manager::schema()->create('obj_equipments', function ($table) {
        $table->id();
		$table->unsignedBigInteger('object_id')->comment('ID объекта');
        $table->unsignedBigInteger('equipment_id')->nullable()->unique()->comment('ID позиции из справочника');
        $table->json('field_properties_data')->nullable()->comment('Характеристики полей оборудования - заполнение по шаблону');
        $table->timestamps(); // Дата создания и дата обновления

        $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');
        $table->foreign('equipment_id')->references('id')->on('book_equipments')->onDelete('set null');
	});

    $fields = [
        [
            [
                'db_field_name' => 'name1',
                'val' => 'Имя 1 значение'
            ],
            [
                'db_field_name' => 'name2',
                'val' => 'Имя 2 значение'
            ],
            [
                'db_field_name' => 'date',
                'val' => '01-02-2024'
            ]
        ],
        [
            [
                'db_field_name' => 'name1',
                'val' => 'Имя 1 значение'
            ],
            [
                'db_field_name' => 'name2',
                'val' => 'Имя 2 значение'
            ],
            [
                'db_field_name' => 'date',
                'val' => '01-02-2024'
            ]
        ],
        [
            [
                'db_field_name' => 'name1',
                'val' => 'Имя 1 значение'
            ],
            [
                'db_field_name' => 'name2',
                'val' => 'Имя 2 значение'
            ],
            [
                'db_field_name' => 'date',
                'val' => '01-02-2024'
            ]
        ]
    ];

    $fields = json_encode($fields);

	$test_arr = [
		[
			'object_id' => 1,
            'equipment_id' => 1,
            'field_properties_data' => $fields
        ],
        [
			'object_id' => 1,
            'equipment_id' => 2,
            'field_properties_data' => $fields
        ],
        [
			'object_id' => 1,
            'equipment_id' => 3,
            'field_properties_data' => $fields
        ]
	];
	
	
	foreach ($test_arr as $arr) {
		ObjEquipments::create($arr);
	}

}