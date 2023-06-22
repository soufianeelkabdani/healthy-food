<?php
require_once('../classes/db.classes.php');
require_once('../classes/dejeuner.classes.php');

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les valeurs du formulaire
    $nom = $_POST['nom'];
    $sousNom = $_POST['snom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $image = $_FILES['images']['name'];
    $idCategorie = 1; 

    // Instancier la classe "Nourriture"
    $nourriture = new Nourriture();

    // Appeler la méthode "insertNourriture" pour insérer les données dans la table
    if ($nourriture->insertNourriture($nom, $sousNom, $description, $prix, $image, $idCategorie)) {
        // L'insertion a réussi
        echo "Données insérées avec succès.";
    } else {
        // L'insertion a échoué
        echo "Échec de l'insertion des données.";
    }
}
?>
