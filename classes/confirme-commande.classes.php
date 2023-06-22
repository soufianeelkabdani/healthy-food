<?php
require_once 'db.classes.php';
session_start();
class Commande extends db{
 
    public function mettreAJourCommande($Id_commande,$Id_utilisateur) {

        $pdo = $this->getPdo();



        $query = "UPDATE Commander
        SET Status = 'En cours de préparation'
        WHERE Id_utilisateur = :Id_utilisateur
          AND Id_commande = :Id_commande
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':Id_utilisateur', $Id_utilisateur);
        $stmt->bindParam(':Id_commande', $Id_commande);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

   
}
?>
