<?php namespace Schemas;

class Appuser{

	const COLUMNS = [
		'Id_Appuser' => ['type' => 'varchar(255)', 'nullable' => '0' , 'default' => ''],
		'login' => ['type' => 'varchar(255)', 'nullable' => '1' , 'default' => ''],
		'password' => ['type' => 'varchar(50)', 'nullable' => '1' , 'default' => '']
	];

}