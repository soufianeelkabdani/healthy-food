<?php
require_once 'db.classes.php';

class UserDB extends DB {
    public function getUserByEmail($email) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE Email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function registerUser($nom, $prenom, $adresse, $telephone, $email, $password) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare('INSERT INTO utilisateurs (Nom_, Prenom, Adresse, Numero_telephone, Email, Mot_de_passe) VALUES (:nom, :prenom, :adresse, :telephone, :email, :password)');
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':adresse', $adresse);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
}
?>
