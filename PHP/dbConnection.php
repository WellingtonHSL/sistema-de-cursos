<?php
require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

class MongoDBConnection {
    private static $instance = null;
    private $client;
    private $database;

    private function __construct() {
        $this->client = new Client("mongodb://localhost:27017");
        $this->database = $this->client->selectDatabase("sistema-de-cursos");

        $this->ensureCollectionExists("course");
        $this->ensureCollectionExists("student");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new MongoDBConnection();
        }
        return self::$instance;
    }

    private function ensureCollectionExists($collectionName) {
        $collections = $this->database->listCollections();

        $collectionExists = false;
        foreach ($collections as $collection) {
            if ($collection->getName() === $collectionName) {
                $collectionExists = true;
                break;
            }
        }

        if (!$collectionExists) {
            $this->database->createCollection($collectionName);
        }
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getCollection($collectionName) {
        try {
            return $this->database->selectCollection($collectionName);
        } catch (Exception $e) {
            echo "Erro ao acessar a coleção: " . $e->getMessage();
            return null;
        }
    }
}
?>