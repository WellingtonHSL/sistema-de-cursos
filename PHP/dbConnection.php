<?php
require 'vendor/autoload.php';

use MongoDB\Client;

class MongoDBConnection {
    private static $instance = null;
    private $client;
    private $database;

    private function __construct() {
        $this->client = new Client("mongodb://localhost:27017");
        $this->database = $this->client->selectDatabase("sistema-de-cursos");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new MongoDBConnection();
        }
        return self::$instance;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getCollection($collectionName) {
        return $this->database->selectCollection($collectionName);
    }
}
?>