<?php

namespace Services;

use PDO;
use PDOException;

class DatabaseService
{
    public string $table;
    public string $pk;
    public function __construct(string $table = null)
    {
        $this->table = $table;
        $this->pk = "id_" . $this->table;
    }
    private static ?PDO $connection = null;
    private function connect(): PDO
    {
        if (self::$connection == null) {
            $config = $_ENV['config']->db;
            $host = $config->host;
            $port = $config->port;
            $dbName = $config->dbName;
            $dsn = "mysql:host=$host;port=$port;dbname=$dbName";
            $user = $config->user;
            $pass = $config->pass;
            try {
                $dbConnection = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    )
                );
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données :
$e->getMessage()");
            }
            self::$connection = $dbConnection;
        }
        return self::$connection;
    }
    public function query(string $sql, array $params = []): object
    {
        $statment = $this->connect()->prepare($sql);
        $result = $statment->execute($params);
        return (object)['result' => $result, 'statment' => $statment];
    }
    /**
     * Retourne la liste des tables en base de données sous forme de tableau
     */
    public static function getTables(): array
    {
        $dbs = new DatabaseService('');
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = ?";
        $resp = $dbs->query($sql, [$_ENV['config']->db->dbName]);
        $tables = $resp->statment->fetchAll(PDO::FETCH_COLUMN);
        return $tables;
    }
    /**
     * Retourne les lignes correspondant à la condition where
     */
    public function selectWhere(string $where = "1", array $bind = [], bool $is_deleted = false): array
    {
        if ($where != "1") {
            $where = $where . '=?';
        }
        $sql = "SELECT * FROM $this->table WHERE $where AND is_deleted = ?;";
        array_push($bind, $is_deleted);
        $resp = $this->query($sql, $bind);
        $rows = $resp->statment->fetchAll(PDO::FETCH_CLASS);
        return $rows;
    }
    /**
     * Retourne la liste des colonnes d'une table (son schéma)
     */
    public function getSchema() : array
    {
        $schemas = [];
        $sql = "SHOW FULL COLUMNS FROM $this->table";
        $resp = $this->query($sql);
        $schemas = $resp->statment->fetchAll(PDO::FETCH_ASSOC);
        return $schemas;
    }
}
