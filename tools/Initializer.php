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
        $tableFile = "src/schemas/Table.php";

        if (file_exists($tableFile) && $isForce) {
            //???
            //Supprimer le fichier s’il existe
            if (!unlink($tableFile)) {
                //Si la suppression ne fonctionne pas déclenche une Exception 
                throw new ErrorException($tableFile);
            }
        }
        if (!file_exists($tableFile)) {
            //???
            //Créer le fichier (voir exemple ci dessous)
            $fileContent = "<?php namespace Schemas; \r\n\r\n ";
            $fileContent .= "class Table{ \r\n\r\n";
            foreach ($tables as $table) {
                $const =  strtoupper($table);
                $fileContent .= "const $const = '$table'; \r\n";
            }
            $fileContent .= "}";
            if (!file_put_contents($tableFile, $fileContent)) {
                //Si l'écriture ne fonctionne pas déclenche une Exception 
                throw new ErrorException($tableFile);
            }
            return $tables;
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

            self::writeTableFile($isForce); //when the function is inside "SELF"

        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
