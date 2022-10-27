<?php namespace Schemas;

class Appuser{

	const COLUMNS = [
		'Id_Appuser' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'login' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'password' => ['type' => 'varchar(50)', 'nullable' => '0' , 'default' => ''],
		'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '0' , 'default' => '0']
	];

}