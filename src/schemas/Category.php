<?php namespace Schemas;

class Category{

	const COLUMNS = [
		'Id_Category' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'title' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => ''],
		'description' => ['type' => 'text', 'nullable' => '1' , 'default' => ''],
		'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '0' , 'default' => '']
	];

}