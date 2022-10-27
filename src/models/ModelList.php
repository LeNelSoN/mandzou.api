<?php

namespace Models;

use Services\DatabaseService;

class ModelList
{
    public string $table;
    public string $pk;
    public array $items; //liste des instances de la classe Model

    public function __construct(string $table, array $list)
    {
        $this->table = $table;
        $this->pk = "Id_".ucfirst($table);
        $this->items = [];
        $this->schema = Self::getSchema($this->table);
        foreach ($list as $json) {
            array_push($this->items, new Model($this->table, $json)); 
        }

    }
    private static function getSchema(string $table): array
    {
        $schemaName = "Schemas\\".ucfirst($table);
        $columns = $schemaName::COLUMNS;
        return $columns;
    }
    /**
     * Même principe que pour Model mais sur une liste ($this->items)
     */
    public function data(): array
    {
        $data = (array) clone $this;
        foreach($data["items"] as $key => $value) {
            $data["items"][$key] = $value->data();
        }
        $data = $data["items"];
        return $data;
    }
    /**
     * Renvoie la liste des id contenus dans $this->items
     */
    public function idList($key = null): array
    {
        $idList = [];
        if (!isset($key)) {
            $key = $this->pk;
        }
        foreach ($this->items as $value) {
           array_push($idList, $value->$key);
        }
        return $idList;
    }
    /**
     * Renvoie l'instance contenue dans $this->items correspondant à $id
     */
    public function findById($id): ?Model
    {
        foreach ($this->items as $item) {
            $pk = $this->pk;
            if($item->$pk === $id )
                return $item;
            }
        return null;
    }
}
