<?php

declare(strict_types = 1);
namespace TODO\App\models;
use TODO\App\database\Databasehdlr;
class Authmodel {

    
    public function isEmailRegistered(string $email) {

        $con = new Databasehdlr();
        $query = "SELECT email FROM userinfo WHERE email = :email;";
        $stmt = $con->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute(); 
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $res; 

    }

    public function isUsernameTaken(string $username) {
        $con = new Databasehdlr();
        $query = "SELECT username FROM userinfo WHERE username = :username;";
        $stmt = $con->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute(); 
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $res; 

    }

    public function addUserInfo(string $username, string $email, string $password, string $avatar): bool {
         
        $con = new Databasehdlr();
        $query = "INSERT INTO userInfo (username, email, password, avatar) 
                  VALUES (:username, :email, :password, :avatar)";
        $stmt = $con->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email'   , $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':avatar'  , $avatar);
        return $stmt->execute(); 
    }

    public function getUserByEmail(string $email) {
        $con = new Databasehdlr();
        $query = "SELECT * FROM userInfo WHERE email = ?;";
        $stmt = $con->pdo->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}