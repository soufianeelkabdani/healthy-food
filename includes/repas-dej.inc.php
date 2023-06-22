<?php
require_once '../classes/db.classes.php';
$db = new DB();
$pdo = $db->getPdo();

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $sousNom = $_POST['sous-nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $image = $_FILES['importation-images']['name'];
    $idCategorie = $_POST['categories'];

    // Connexion à la base de données
    $db = new DB();
    $pdo = $db->getPdo();

    // Requête de jointure et d'insertion des données
    $stmt = $pdo->prepare('INSERT INTO nourritures (Nom, Sous_nom, Description_, Prix, _Image, id_categorie)
                           SELECT ?, ?, ?, ?, ?, c.id_categorie
                           FROM categories c
                           WHERE c.id_categorie = ?');
    $stmt->execute([$nom, $sousNom, $description, $prix, $image, $idCategorie]);

    // Récupérer le nombre d'enregistrements dans la catégorie correspondante
    $stmt = $pdo->prepare('SELECT COUNT(*) AS count FROM nourritures 
                           INNER JOIN categories ON nourritures.id_categorie = categories.id_categorie
                           WHERE nourritures.id_categorie = ?');
    $stmt->execute([$idCategorie]);
    $row = $stmt->fetch();

    $count = $row['count'];
    echo 'Nombre d\'enregistrements dans la catégorie : ' . $count;

    // Redirection vers la page petit-dejeuner.php
    header('Location: ../dejeuner.php');
    exit();
}
?>

