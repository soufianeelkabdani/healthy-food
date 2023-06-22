<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    require_once('../classes/db.classes.php');
    require_once('../classes/signup.classes.php');
    session_start();
    
    $postData = json_decode(file_get_contents('php://input'), true);

    $nom = $postData['nom'];
    $prenom = $postData['prenom'];
    $adresse = $postData['adresse'];
    $telephone = $postData['telephone'];
    $email = $postData['email'];
    $motDePasse = $postData['password'];

    // Hash the password
    $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Créer une instance de la classe UserDB
    $userDB = new UserDB();

    // Enregistrer l'utilisateur dans la base de données
    $success = $userDB->registerUser($nom, $prenom, $adresse, $telephone, $email, $hashedPassword);
    if ($success) {
        // L'utilisateur a été enregistré avec succès
        $_SESSION['Id_utilisateur'] = $success['Id_utilisateur'];
        $_SESSION['Nom_'] = $success['Nom_'];
        $_SESSION['Prenom'] = $success['Prenom'];
        $_SESSION['Email'] = $success['Email'];
        $_SESSION['admin'] = $success['admin'];
        
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // Une erreur s'est produite lors de l'enregistrement
        $response = array('status' => 'failure');
        echo json_encode($response);

    }
}
