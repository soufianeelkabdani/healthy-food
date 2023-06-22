<?php
// Démarrer la session
session_start();

if (isset($_POST['submit'])) {
    require_once '../classes/db.classes.php';
    $db = new DB();
    $pdo = $db->getPdo();

    $articleId = $_POST['supprimer_id'];

    try {
        // Récupérer l'ID de la catégorie pour la redirection
        $query = "SELECT id_categorie FROM nourritures WHERE Id_nourriture = :articleId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $categoryId = $result['id_categorie'];

        // Préparer la requête de suppression
        $query = "DELETE FROM nourritures WHERE Id_nourriture = :articleId";
        $stmt = $pdo->prepare($query);

        // Liaison de la valeur de l'ID de l'article
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);

        // Exécuter la requête de suppression
        $stmt->execute();

        // Redirection après suppression
        header('location: ../repas-admin.php');
        exit();
    } catch (PDOException $e) {
        echo "Une erreur s'est produite lors de la suppression de l'article : " . $e->getMessage();
    }
} else {
    echo "ID de l'article non spécifié.";
}
?>
