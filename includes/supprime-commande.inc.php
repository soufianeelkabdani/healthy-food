<?php
require_once '../classes/db.classes.php';
require_once '../classes/supprime-commande.classes.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-button'])) {
    $idCommande = $_POST['commande-id'];

    $commander = new Commander();
    $commander->deleteCommande($idCommande);

    // Effectuez des actions supplémentaires si nécessaire, par exemple, redirigez vers une autre page
    header("Location: ../commande-admin.php");
    exit();
}
?>
