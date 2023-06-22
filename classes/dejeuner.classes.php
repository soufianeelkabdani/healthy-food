<?php
require_once 'db.classes.php';
// Démarrer la session
session_start();

class Nourriture extends DB {
    public function insertNourriture($nom, $sousNom, $description, $prix, $image, $idCategorie) {
        $pdo = $this->getPdo();

        // Vérifier si un fichier a été téléchargé
        if ($_FILES['images']['error'] === UPLOAD_ERR_OK) {
            $tempFile = $_FILES['images']['tmp_name'];

            // Valider le type de fichier (uniquement les images)
            $allowedTypes = ['image/jpeg', 'image/png'];
            $fileType = $_FILES['images']['type'];
            if (!in_array($fileType, $allowedTypes)) {
                return false; // Type de fichier non valide
            }

            // Définir le chemin de destination du fichier
            $destination = "../img/" . basename($_FILES['images']['name']);
            // Déplacer le fichier téléchargé vers le dossier de destination
            if (!move_uploaded_file($tempFile, $destination)) {
                return false; // Erreur lors du déplacement du fichier
            }

            $image = $_FILES['images']['name'];
        } else {
            return false; // Aucun fichier téléchargé
        }

        // Préparer la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO nourritures (Nom, Sous_nom, Description_, Prix, _Image, id_categorie)
                               VALUES (:nom, :sousNom, :description, :prix, :image, :idCategorie)");

        // Lier les valeurs des paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':sousNom', $sousNom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':idCategorie', $idCategorie);

        // Exécuter la requête
        $stmt->execute();

        // Vérifier si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Redirection vers dejeuner.php
            header("Location: ../dejeuner.php");
            exit(); // Assurez-vous d'appeler exit() pour terminer le script après la redirection
        } else {
            return false; // Échec de l'insertion
        }
    }
}
?>
