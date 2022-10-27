<?php namespace Schemas;

class Product{

	const COLUMNS = [
		'Id_Product' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'title_fr' => ['type' => 'varchar(50)', 'nullable' => '1' , 'default' => ''],
		'title_en' => ['type' => 'varchar(50)', 'nullable' => '1' , 'default' => ''],
		'description_en' => ['type' => 'varchar(50)', 'nullable' => '1' , 'default' => ''],
		'description_fr' => ['type' => 'text', 'nullable' => '1' , 'default' => ''],
		'price' => ['type' => 'decimal(15,2)', 'nullable' => '1' , 'default' => ''],
		'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '0' , 'default' => ''],
		'Id_Cart' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => ''],
		'Id_Category' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => '']
	];

}