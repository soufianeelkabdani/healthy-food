    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        require_once('../classes/db.classes.php');
        require_once('../classes/login.classes.php');

        $response = array(); // Initialise la réponse

        // Get the JSON data from the request body
        $jsonData = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $user = json_decode($jsonData, true);

        // Extract the user data from the associative array
        $email = $user['login_email'];
        $password = $user['login_password'];

        // Créer une instance de la classe UserDB
        $loginDB = new LoginDB();

        // Récupérer l'utilisateur par e-mail
        $userData = $loginDB->getUserByEmail($email);

        if ($userData && password_verify($password, $userData['Mot_de_passe'])) {
            // L'utilisateur est authentifié avec succès
            $response['status'] = 'success';
            $response['message'] = 'Authentification réussie.';
            session_start();
            $_SESSION['Id_utilisateur'] = $userData['Id_utilisateur'];
            $_SESSION['Nom_'] = $userData['Nom_'];
            $_SESSION['Prenom'] = $userData['Prenom'];
            $_SESSION['Email'] = $userData['Email'];
            $_SESSION['admin'] = $userData['admin'];

        
        } else {
            // Échec de l'authentification
            $response['status'] = 'error';
            $response['message'] = 'Adresse e-mail ou mot de passe incorrect.';
        }

        // Renvoyer la réponse JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    ?>


