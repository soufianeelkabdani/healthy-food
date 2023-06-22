<?php
session_start();
require_once '../classes/db.classes.php';

// Créer une instance de la classe DB
$db = new DB();

// Récupérer l'objet PDO connecté à la base de données
$pdo = $db->getPdo();



// Récupérer l'ID de l'utilisateur connecté
$userId = $_SESSION['id_utilisateur'];

// Récupérer les valeurs des champs du formulaire
$idNourriture = $_POST['id_modifier'];
$idCategorie = $_POST['id_categorie'];
$nom = $_POST['nom'];
$sousNom = $_POST['sous_nom'];
$image = $_FILES['image']['name']; // Nom du fichier image
$description = $_POST['description'];
$prix = $_POST['prix'];

// Vérifier si un fichier d'image a été téléchargé
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Déplacer le fichier téléchargé vers le dossier de destination
    $destination = 'chemin/vers/le/dossier/destination/' . $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
} else {
    // Utiliser la valeur existante de l'image si aucun fichier n'a été téléchargé
    $image = $_POST['image_existing'];
}

// Préparer et exécuter la requête de mise à jour
$sql = "UPDATE nourritures SET Nom = :nom, Sous_nom = :sousNom, _Image = :image, Description_ = :description, Prix = :prix WHERE Id_nourriture = :idNourriture AND Id_utilisateur = :userId";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'nom' => $nom,
    'sousNom' => $sousNom,
    'image' => $image,
    'description' => $description,
    'prix' => $prix,
    'idNourriture' => $idNourriture,
    'userId' => $userId
]);

// Redirection vers la page spécifique en fonction de la catégorie
if ($idCategorie == 1) {
    header("Location: ../petit-dejeuner.php");
} elseif ($idCategorie == 2) {
    header("Location: ../dejeuner.php");
} elseif ($idCategorie == 3) {
    header("Location: ../collation.php");
} elseif ($idCategorie == 4) {
    header("Location: ../diner.php");
} else {
    // Redirection vers une page par défaut si la catégorie n'est pas reconnue
    header("Location: default.php");
}
?>
