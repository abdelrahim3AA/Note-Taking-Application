<?php

namespace TODO\App\database;
use FTP\Connection;
use PDO;
use PDOException;

class Databasehdlr {
    public PDO $pdo; 

    public function __construct() {
        $this->pdo = new PDO('mysql:server=localhost;dbname=noteapp', 'root', ''); 
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            die('Error in Connection'. $e->getMessage()); 
        }

        // return new connection(); 
    }
}