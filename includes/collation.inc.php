<?php
session_start();

require_once('../classes/db.classes.php');
require_once('../classes/collation.classes.php');



// Vérifiez si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérez les valeurs du formulaire
    $nom = $_POST['nom'];
    $sousNom = $_POST['snom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $image = $_FILES['images']['name'];
    $idCategorie = 1; // L'ID de la catégorie correspondante (vous pouvez ajuster cela en fonction de votre logique)

    // Instanciez la classe "Nourriture"
    $nourriture = new Nourriture();

    // Appelez la méthode "insertNourriture" pour insérer les données dans la table
    if ($nourriture->insertNourriture($nom, $sousNom, $description, $prix, $image, $idCategorie)) {
        // L'insertion a réussi
        echo "Données insérées avec succès.";
    } else {
        // L'insertion a échoué
        echo "Échec de l'insertion des données.";
    }
}
?>
