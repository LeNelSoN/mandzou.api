<?php namespace Models;

use Services\DatabaseService;

class Model
{

    /**
     * Renvoie le schéma (colonnes de la table) défini dans la classe Schemas
     * correspondant à $table sous forme de tableau associatif
     * (classe Schemas généré au sprint 4)
     */
    private static function getSchema(string $table): array
    {
        $schemaName = "Schemas\\".ucfirst($table);
        $columns = $schemaName::COLUMNS;
        return $columns;
    }
    /**
     * Crée un identifiant unique de $length caractères (par defaut)
     * L'idée est de se servir de la fonction microtime() pour récupérer le timestamp
     * Puis de le convertir en base 32 [a-z][0-9] ce qui vous donnera 9 caractères
     * Completer ensuite en générant autant de caractère aléatoire (base 32)
     * que nécessaire pour obtenir la $length souhaitée (16 par defaut)
     */
    private function nextGuid(int $length = 16): string
    {
        $guid = base_convert(microtime(),10,32);
        for ($i = strlen($guid); $i < $length; $i = strlen($guid)) { 
            $rnd = base_convert(rand(0, 32),9,32);
            $guid .= $rnd;
        }
        if(strlen($guid) > $length){
            $guid = substr($guid, 0, $length);
        }
        return $guid;
    }
    public string $table;
    public string $pk;
    public array $schema;
    /**
     * 1. initialise les 3 variables $this->table,
     * $this->pk (nom de l'id de la table)
     * et $this->schema (à l'aide de getSchema)
     * 2. le param $json correspond aux données en entrée
     * (ex pour la table role : ["id_role"=>"...", "title"=>"", ...])
     * si $json ne contient pas d'id, crée un nouvel id (nextGuid)
     * 3. ajoute à l'instance toutes les colonnes contenues dans $json
     * si elles sont présentes dans le schéma
     * 4. complète le contenu de $json pour obtenir une instance ayant
     * les mêmes propriétés que le schéma
     * (avec des valeurs par défaut si elles sont définit dans le schéma)
     * (ex pour la table role, $json vaut ["title"=>"seller", "weight"=>2,"nimportequoi"=>"..."])
     * seul title et weight existent dans la table (schema),
     * ils sont donc ajoutés comme variable à l'instance
     * nimportequoi n'est pas gardé,
     * $this->title = "seller" et $this->weight = 2
     * il manque les colonnes id_role et is_deleted
     * id_role étant manquant, on le crée avec nextGuid,
     * $this->id_role = "................" (16 caractères)
     * is_deleted à une valeur par défaut qui vaut 0 dans le schéma,
     * $this->is_deleted = 0
     * une fois construite, notre instance, en plus des variables table, pk etschema,
     * possede les variables id_role, title, weight et is_deleted
     */
    public function __construct(string $table, array $json)
    {
        $this->table = $table;
        $this->pk = "Id_".ucfirst($table);
        $this->schema = Self::getSchema($this->table);
        if(!isset($json[$this->pk]))
        {
            $json[$this->pk] = $this->nextGuid();
        }
        foreach ($this->schema as $key => $value) {
            if(isset($json[$key])){
                $this->$key = $json[$key];
            }
            elseif($this->schema[$key]['nullable'] == 1 && $this->schema[$key]['default'] == ''){
                $this->$key = null;
            }
            else //valeur par défaut
            {
                $this->$key = $this->schema[$key]['default'];
            }
        }
    }
    /**
     * Renvoie la liste des données sous forme de tableau associatif
     * (Récupérez les colonnes grâce au schéma)
     * exemple : une instance de Model correspondant à la table role
     * a pour variables :
     * table, pk, schema, id_role, title, weight et is_deleted
     * seules les variables id_role, title, weight et is_deleted
     * existent en base de données
     * la méthode data les renvoie sous forme de tableau associatif
     * table, pk et schema ne sont pas renvoyée
     */
    public function data(): array
    {
        $data = (array) clone $this;
        foreach(array_keys($data) as $key) {
            if (!isset($this->schema[$key])) {
                unset($data[$key]);
            }
        }
        return $data;
    }
}
