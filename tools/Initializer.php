<?php

namespace Tools;

use Services\DatabaseService;
use Helpers\HttpRequest;
use Exception;
use Helpers\HttpResponse;

class Initializer
{
    /**
     * Génère la classe Schemas\Table (crée le fichier)
     * qui liste toutes les tables en base de données
     * sous forme de constante
     * Renvoie la liste des tables sous forme de tableau
     * Si $isForce vaut false et que la classe existe déjà, elle n'est pas réécrite
     * Si $isForce vaut true, la classe est supprimée (si elle existe) et réécrite
     */
    private static function writeTableFile(bool $isForce = false): array
    {
        $tables = DatabaseService::getTables();
        $tableFile = $_ENV['config']->db->root . "schemas/Table.php";
        foreach ($tables as $key => $value) {
            $tables[$key] = "\t" . 'CONST ' . strtoupper($value) . ' = ' . "'" . $value . "'" . ';' . "\n";
        }
        array_unshift($tables, "<?php namespace Schemas;\n\nclass Table{\n\n");
        array_push($tables, "\n}");

        if (file_exists($tableFile) && $isForce) {
            if (!unlink($tableFile)) {
                throw new Exception("Impossible de supprimer le fichier");
            }
        }
        if (!file_exists($tableFile)) {
            if (!file_put_contents($tableFile, $tables)) {
                throw new Exception("Impossible d'écrire le fichier");
            };
        }
        return $tables;
    }
    /**
     * Génère une classe schema (crée le fichier) pour chaque table présente dans $tables
     * décrivant la structure de la table à l'aide de DatabaseService getSchema()
     * Si $isForce vaut false et que la classe existe déjà, elle n'est pas réécrite
     * Si $isForce vaut true, la classe est supprimée (si elle existe) et réécrite
     */
    public static function writeSchemasFiles(array $tables, bool $isForce): void
    {
        foreach ($tables as $table) {
            $class = ucfirst($table);
            $schemaFile = "src/schemas/ $class .php";
            if (file_exists($schemaFile) && $isForce) {
                //???
                //Supprimer le fichier s’il existe
                //Si la suppression ne fonctionne pas déclenche une Exception
                if (!unlink($schemaFile)) {
                    throw new Exception("Impossible de supprimer le fichier");
                }
            }
            if (!file_exists($schemaFile)) {
                //???
                //Créer le fichier (voir exemple ci dessous)
                //Si l’écriture ne fonctionne pas déclenche une Exception
                $dbs = new DatabaseService();
                $schema = $dbs->getSchema();
                $fileContent = "<?php namespace Schemas; \r\n\r\n ";
                $fileContent .= "class $class{ \r\n\r\n";
                $prefix = "";
                foreach ($schema as $column) {
                    $fileContent .= $prefix . "'" . $column["Field"] . "' => ['type' => '" . $column["Type"] . "', 'nullable' => ";
                    $nullable = $column["Null"] == 'NO' ? "'0'" : "'1'";
                    $fileContent .= $nullable . " , 'default' => '" . $column["Default"] . "']";
                    $prefix = ",\n\t\t";
                }
                $fileContent .= "\n\t];\n\r\n}";
                if (!file_put_contents($schemaFile, $fileContent)) {
                    throw new Exception("Impossible d'écrire le fichier");
                };
            }
        }
    }


    /**
     * Exécute la méthode writeTableFile
     * Renvoie true si l'exécution s'est bien passée, false sinon
     */
    public static function start(HttpRequest $request): bool
    {
        $isForce = count($request->route) > 1 && $request->route[1] == 'force';
        try {
            $tables= Self::writeTableFile($isForce);
            Self::writeSchemasFiles($tables,$isForce);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
