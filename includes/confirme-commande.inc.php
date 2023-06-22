<?php


require_once '../classes/db.classes.php';
require_once '../classes/confirme-commande.classes.php';

if (isset($_POST['commande-id']) && isset($_POST['Id_utilisateur'])) {
    $idCommande = $_POST['commande-id'];
    $Id_utilisateur = $_POST['Id_utilisateur'];

    $commander = new Commande();
    $commander->mettreAJourCommande($idCommande,$Id_utilisateur);
    if($commander) header('location: ../commande-admin.php');
}
?>

