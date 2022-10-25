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
        $tableFile = $_ENV['config']->db->root."schemas/Table.php";
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
     * Exécute la méthode writeTableFile
     * Renvoie true si l'exécution s'est bien passée, false sinon
     */
    public static function start(HttpRequest $request): bool
    {
        $isForce = count($request->route) > 1 && $request->route[1] == 'force';
        try {
            Self::writeTableFile($isForce);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
