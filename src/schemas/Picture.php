<?php namespace Schemas;

class Picture{

	const COLUMNS = [
		'Id_Picture' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'url' => ['type' => 'text', 'nullable' => '1' , 'default' => ''],
		'alt' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => ''],
		'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '1' , 'default' => ''],
		'Id_Product' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => '']
	];

}