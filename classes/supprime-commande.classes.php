<?php
require_once 'db.classes.php';

class Commander extends DB {
    public function deleteCommande($idCommande) {
        // Démarrer la session

 

        $pdo = $this->getPdo();
        $sql = "DELETE FROM commander WHERE Id_commande = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idCommande);
        $stmt->execute();
    }
}
?>
