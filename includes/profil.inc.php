<?php
session_start();
require_once '../classes/db.classes.php';
require_once '../classes/profil.classes.php';

if (isset($_POST['submit'])) {
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $motdepasse = $_POST['motdepasse'];

    $utilisateur = new Utilisateur();
    if ($utilisateur->mettreAJourUtilisateur($adresse, $telephone, $motdepasse)) {
        $message = "Mise à jour réussie";
    } else {
        $message = "Aucune mise à jour effectuée";
    }

    if (isset($_FILES['profile-img']) && $_FILES['profile-img']['name'] != "") {
        $utilisateur->mettreAJourImageUtilisateur($_FILES['profile-img']);
    }

    // Redirection après la mise à jour
    header('Location: ../profil.php?message=' . urlencode($message));
    exit();
}
?>
