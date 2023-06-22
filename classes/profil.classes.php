<?php
require_once 'db.classes.php';
session_start();

class Utilisateur {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function mettreAJourUtilisateur($adresse, $telephone, $motdepasse) {
        $pdo = $this->db->getPdo();

        $idUtilisateur = $_SESSION['Id_utilisateur'];

        $query = "UPDATE utilisateurs SET Adresse = :adresse, Numero_telephone = :telephone, Mot_de_passe = :motdepasse WHERE Id_utilisateur = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':motdepasse', $motdepasse);
        $stmt->bindParam(':id', $idUtilisateur);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function mettreAJourImageUtilisateur($image) {
        $pdo = $this->db->getPdo();

        $idUtilisateur = $_SESSION['Id_utilisateur'];

        if (isset($_FILES['profile-img']) && $_FILES['profile-img']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['profile-img']['tmp_name'];
            $fileName = uniqid() . '-' . $_FILES['profile-img']['name'];

            move_uploaded_file($tmpName, '../img/' . $fileName);

            $query = "UPDATE utilisateurs SET Image = :image WHERE Id_utilisateur = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':image', $fileName);
            $stmt->bindParam(':id', $idUtilisateur);
            $stmt->execute();

            // ... Affichage de message ou autre traitement ...
            echo "Image mise à jour avec succès !";
        } else {
            echo "Aucun fichier sélectionné ou erreur lors du téléchargement de l'image.";
        }
    }
}
?>
