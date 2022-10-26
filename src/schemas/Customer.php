<?php namespace Schemas;

class Customer{

	const COLUMNS = [
		'Id_Customer' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'first_name' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => ''],
		'last_name' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => ''],
		'address' => ['type' => 'text', 'nullable' => '1' , 'default' => ''],
		'is_admin' => ['type' => 'tinyint(1)', 'nullable' => '1' , 'default' => ''],
		'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '1' , 'default' => ''],
		'Id_Appuser' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => '']
	];

}