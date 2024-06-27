<?php
declare(strict_types = 1);
namespace TODO\App\models;
use TODO\App\database\Databasehdlr;

class Usermodel {

    public function getUserId(string $username) {

        $con = new Databasehdlr();
        $query = "SELECT id FROM userInfo WHERE username = :username;";
        $stmt = $con->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $res;
    }

    public function changeAvatar($newAvatar, $userId) {
        try {
            $con = new Databasehdlr();
            $query = "UPDATE userInfo SET avatar = :avatar WHERE id = :id;";
            $stmt = $con->pdo->prepare($query);
            $stmt->bindParam(':avatar', $newAvatar);
            $stmt->bindParam(':id', $userId);
            $result = $stmt->execute();
            if ($result) {
                error_log('Avatar updated in database for user ID: ' . $userId);
            } else {
                error_log('Failed to update avatar in database for user ID: ' . $userId);
            }
            return $result;
        } catch (\PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
    
    
}
