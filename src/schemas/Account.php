<?php namespace Schemas;

class Account{
    
const COLUMNS = [
'id_account' => ['type' => 'varchar(255)', 'nullable' => '', 'default' => ''],
'login' => ['type' => 'varchar(255)', 'nullable' => '', 'default' => ''],
'password' => ['type' => 'varchar(255)', 'nullable' => '', 'default' => ''],
'connected_at' => ['type' => 'datetime', 'nullable' => '1', 'default' => ''],
'authenticated_at' => ['type' => 'datetime', 'nullable' => '1', 'default' => ''],
'id_role' => ['type' => 'varchar(255)', 'nullable' => '', 'default' => '1'],
'id_customer' => ['type' => 'varchar(255)', 'nullable' => '', 'default' => ''],
'is_deleted' => ['type' => 'tinyint(1)', 'nullable' => '', 'default' => '0']
];
}
