<?php
require_once 'db.classes.php';

class loginDB extends DB {
    public function getUserByEmail($email) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE Email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
