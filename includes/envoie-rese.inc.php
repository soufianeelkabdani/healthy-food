<?php
require_once('../classes/db.classes.php');

// Démarrer la session
session_start();

$db = new DB();
$pdo = $db->getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID de l'utilisateur est défini dans la session
    if (isset($_SESSION['Id_utilisateur'])) {
        $userId = $_SESSION['Id_utilisateur']; // Utiliser la clé correcte pour l'ID de l'utilisateur
        $quantity = $_POST['quantity'];
        $totalPrice = $_POST['totalPrice'];
        $foodId = $_POST['foodId'];

        // Insérer les informations dans la base de données
        $sql = "INSERT INTO commander (Id_utilisateur, Id_nourriture, Nombre_de_commande, Montant_de_commande) VALUES (:userId, :foodId, :quantity, :totalPrice)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':foodId', $foodId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_INT);

        if ($stmt !== false && $stmt->execute()) {
            // Succès, faites ce que vous voulez ici

            // Par exemple, renvoyer une réponse JSON avec un message de succès
            $response = array(
                'status' => 'success',
                'message' => 'La réservation a été effectuée avec succès.',
                'location' => '../status.php'

            );
          // Modify the "location" value before encoding the response as JSON
$response['location'] = str_replace('\\/', '/', $response['location']);

// Output the JSON response
echo json_encode($response);

            
        } else {
            // Échec de l'insertion dans la base de données

            // Par exemple, renvoyer une réponse JSON avec un message d'erreur
            $response = array(
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la réservation.'
            );
            echo json_encode($response);
        }
    } else {
        // ID de l'utilisateur non spécifié dans la session
        echo "ID de l'utilisateur non spécifié.";
    }
}
?>
