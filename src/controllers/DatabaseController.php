<?php namespace Controllers;
use Services\DatabaseService;
use Helpers\HttpRequest;
class DatabaseController
{
private string $table;
private string $pk;
private ?string $id;
private array $body;
private string $action;

public function __construct(HttpRequest $request)
{
/* initialiser les 5 variables de la classe */
}

/**
* Retourne le résultat de la méthode ($action) exécutée
*/
public function execute() : ?array
{
    if($this->action == "GET"){
        return $this->get();
    }
}
/**
* Action exécutée lors d'un GET
* Retourne le résultat du selectWhere de DatabaseService
* soit sous forme d'un tableau contenant toutes le lignes (si pas d'id)
* soit sous forme du tableau associatif correspondant à une ligne (si id)
*/
private function get() : ?array
{
    $dbs = new DatabaseService($this->table);
    if ($this->id == "0") {
        return $dbs->selectWhere();
    }
    return $dbs->selectWhere($this->pk, [$this->id]);
}
}

    
