<?php
require_once '../classes/db.classes.php';
$db = new DB();
$pdo = $db->getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commandeId = $_POST['commande_id'];
    $nouveauStatut = $_POST['status'];

    $sqlUpdate = "UPDATE commander SET Status = :nouveauStatut WHERE Id_commande = :commandeId";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindValue(':nouveauStatut', $nouveauStatut, PDO::PARAM_STR);
    $stmtUpdate->bindValue(':commandeId', $commandeId, PDO::PARAM_INT);
    $stmtUpdate->execute();

    header("Location: ../livraison-admin.php");
    exit();
}
?>
