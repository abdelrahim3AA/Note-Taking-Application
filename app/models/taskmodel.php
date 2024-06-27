<?php

namespace TODO\App\models;
use TODO\App\database\Databasehdlr;

class Taskmodel
{
    private $id;
    private $title;
    private $description;
    private $created_at;
    private $updated_at;

    public function addTask($title, $description, $id)
    {
        $con = new Databasehdlr();
        /// insert into TODO table
        $stmt1 = $con->pdo->prepare('INSERT INTO note(title, description, created_at, userId)
        VALUES(:title, :description, :created_at, :userId)');
        $stmt1->bindValue(':title', $title);
        $stmt1->bindValue(':description', $description);
        $stmt1->bindValue(':created_at', date("Y-m-d H:i:s"));
        $stmt1->bindValue(':userId', $id);
        $stmt1->execute();
        /// insert into ALL_TODOS table for save all notes has been inserted
        $stmt2 = $con->pdo->prepare('INSERT INTO all_notes(title, description, created_at, userId)
        VALUES(:title, :description, :created_at, :userId)');
        $stmt2->bindValue(':title', $title);
        $stmt2->bindValue(':description', $description);
        $stmt2->bindValue(':created_at', date("Y-m-d H:i:s"));
        $stmt2->bindValue(':userId', $id);
        $stmt2->execute();
        header('Location: ' . $_SERVER["HTTP_REFERER"]);
        exit;
    }

    public function getTask($id)
    {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare('SELECT * FROM `note` WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAllTasks($userId)
    {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare('SELECT * FROM `note` WHERE userId = :userId ORDER BY CREATED_AT DESC');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks;
    }
    public function deleteTask($id)
    {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare('DELETE FROM `note` WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        header('Location: ' . $_SERVER["HTTP_REFERER"]);
        exit;
    }
    public function updateTask($newTitle, $newDescription, $id)
    {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare('UPDATE `note` SET `title` = :title,
                `description` = :description ,`updated_at` = :updated_at WHERE `id` = :id');
        $stmt->bindValue(':title', $newTitle);
        $stmt->bindValue(':description', $newDescription);
        $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        
    }

    public function completedTask($id)
    {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare('UPDATE `note` set completed = true where id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        header('Location: ' . $_SERVER["HTTP_REFERER"]);
        exit;
    }

    public function NotcompletedTask($id) {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare('UPDATE `note` set completed = false where id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        header('Location: ' . $_SERVER["HTTP_REFERER"]);
        exit;
    }

    public function deleteAll() {
        $con = new Databasehdlr();
        $stmt = $con->pdo->prepare("TRUNCATE TABLE `noteapp`.`note`"); 
        $stmt->execute(); 
        header('Location: ' . $_SERVER["HTTP_REFERER"]);
        exit;
    }
}
