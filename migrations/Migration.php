<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)); 
$dotenv->load();

$dsn = $_ENV['DSN'] ?? $_ENV['DSN'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];

$driver = '';
if (stripos($dsn, 'pgsql:host') === 0) {
    $driver = 'pgsql';
} elseif (stripos($dsn, 'mysql:host') === 0) {
    $driver = 'mysql';
}

preg_match('/dbname=([^;]+)/', $dsn, $matches);
$dbName = $matches[1] ?? null;

if ($driver === 'pgsql' && $dbName) {
    $dsnDefault = preg_replace('/dbname=([^;]+)/', 'dbname=postgres', $dsn);
    try {
        $pdo = new PDO($dsnDefault, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE \"$dbName\"");
        echo "Base de données \"$dbName\" créée ou déjà existante.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') === false) {
            die("Erreur création base: " . $e->getMessage());
        }
    }
}
if ($driver === 'mysql' && $dbName) {
    $dsnDefault = preg_replace('/dbname=([^;]+)/', '', $dsn);
    try {
        $pdo = new PDO($dsnDefault, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base de données `$dbName` créée ou déjà existante.\n";
    } catch (PDOException $e) {
        die("Erreur création base: " . $e->getMessage());
    }
}

class Migration
{
    private static ?\PDO $pdo = null;
    private static string $driver = '';

    private static function connect()
    {
        global $dsn, $user, $pass, $driver;
        if (self::$pdo === null) {
            self::$pdo = new \PDO($dsn, $user, $pass);
            self::$driver = $driver;
        }
    }

    private static function type($type)
    {
        $map = [
            'id' => [
                'pgsql' => 'SERIAL PRIMARY KEY',
                'mysql' => 'INT AUTO_INCREMENT PRIMARY KEY'
            ],
            'date' => [
                'pgsql' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'mysql' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ]
        ];
        return $map[$type][self::$driver] ?? $type;
    }

    public static function up()
    {
        self::connect();

        $queries = [
            // Table client
            "CREATE TABLE IF NOT EXISTS client (
                id " . self::type('id') . ",
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL
            )",
            // Table compteur
            "CREATE TABLE IF NOT EXISTS compteur (
                id " . self::type('id') . ",
                numero VARCHAR(50) NOT NULL UNIQUE,
                client_id INT NOT NULL,
                FOREIGN KEY (client_id) REFERENCES client(id)
            )",
            // Table achat
            "CREATE TABLE IF NOT EXISTS achat (
                id " . self::type('id') . ",
                reference VARCHAR(100) NOT NULL,
                code VARCHAR(100) NOT NULL,
                date " . self::type('date') . ",
                tranche VARCHAR(10) NOT NULL,
                prix FLOAT NOT NULL,
                nbreKwt FLOAT NOT NULL,
                montant FLOAT NOT NULL,
                statut VARCHAR(10) NOT NULL,
                compteur_id INT NOT NULL,
                client_id INT NOT NULL,
                FOREIGN KEY (compteur_id) REFERENCES compteur(id),
                FOREIGN KEY (client_id) REFERENCES client(id)
            )"
        ];

        foreach ($queries as $sql) {
            self::$pdo->exec($sql);
        }

        echo "Migration terminée avec succès pour le SGBD : " . self::$driver . "\n";
    }
}

Migration::up();