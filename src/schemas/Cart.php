<?php namespace Schemas;

class Cart{

	const COLUMNS = [
		'Id_Cart' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '0' , 'default' => ''],
		'Id_Customer' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => '']
	];

}