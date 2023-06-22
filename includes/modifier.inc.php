<?php
session_start();
require_once('../classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"] ?? null;
    $nom = $_POST["nom"] ?? null;
    $sousNom = $_POST["sous_nom"] ?? null;
    $description = $_POST["description"] ?? null;
    $prix = $_POST["prix"] ?? null;

    $sql = "UPDATE `nourritures` SET Nom = :nom, Sous_nom = :sousNom, Description_ = :description, Prix = :prix WHERE Id_nourriture = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':sousNom', $sousNom, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: ../detail-admin.php?id=$id");
    exit();
}
?>
