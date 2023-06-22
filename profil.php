<?php
session_start();
require_once 'classes/db.classes.php';

$id_utilisateur = $_SESSION['Id_utilisateur'];

$db = new DB();
$pdo = $db->getPdo();

$requete = $pdo->prepare('SELECT * FROM utilisateurs WHERE Id_utilisateur = :id');
$requete->bindValue(':id', $id_utilisateur);
$requete->execute();
$utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="profil.css">
    <title>Profil</title>
</head>
<body>
    <nav class="nav-header">
        <ul>
            <li>
                <a href="accueil.php">ACCUEIL</a>
            </li>
            <li>
                <a href="#" onclick="toggleOptions()">RESERVATION</a>
                <ul id="options" class="options">
                    <li><a href="repas.php">Nourritures saines</a></li>
                    <li><a href="petit-dejeuner-uti.php">Petit-déjeuner</a></li>
                    <li><a href="dejeuner-uti.php">Déjeuner</a></li>
                    <li><a href="collation-uti.php">Collation</a></li>
                    <li><a href="diner-uti.php">Dîner</a></li>
                </ul>
            </li>
            <li>
                <a href="profil.php">PROFIL</a>
            </li>
        </ul>
        <img src="img/logo.png" alt="logo" width="200" height="100">
        <ul>
            <li>
                <a href="status.php">STATUS</a>
            </li>
            <li>
                <a href="classes/logout.classes.php">DECONNEXION</a>
            </li>
        </ul>
    </nav>

    <div class="profile-container">
        <div class="profile-form">
            <form method="post" enctype="multipart/form-data" action="includes/profil.inc.php">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="img/<?php echo $utilisateur['Image']; ?>" alt="" style="width: 30%; border-radius: 50%;">
                    <input type="file" id="profile-img" name="profile-img" accept="image/*">
                </div>
                <label for="nom">Nom</label>
                <input type="text" id="nom" value="<?php echo $utilisateur['Nom_']; ?>" readonly>

                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" value="<?php echo $utilisateur['Prenom']; ?>" readonly>

                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo $utilisateur['Adresse']; ?>" required>

                <label for="telephone">Numéro de téléphone</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo $utilisateur['Numero_telephone']; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" value="<?php echo $utilisateur['Email']; ?>" readonly>

                <label for="motdepasse">Mot de passe</label>
                <input type="password" id="motdepasse" name="motdepasse" value="<?php echo $utilisateur['Mot_de_passe']; ?>" required>

                <button type="submit" name="submit">Enregistrer</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="content-footer">
            <div class="defi">
                <h4>HEALTHY FOOD</h4>
                <p>Notre société est une entreprise spécialisée dans la promotion et la fourniture de solutions culinaires saines et équilibrées. Nous nous engageons à aider les individus à adopter un mode de vie sain en proposant une plateforme en ligne regorgeant de recettes culinaires nutritives</p>
            </div>
            <div class="heure">
                <h4>Heures d'ouverture</h4>
                <ul>
                    <li><span>Lundi</span><span>9:00 - 21:00</span></li>
                    <li><span>Mardi</span><span>9:00 - 21:00</span></li>
                    <li><span>Mercredi</span><span>9:00 - 21:00</span></li>
                    <li><span>Jeudi</span><span>9:00 - 21:00</span></li>
                    <li><span>Vendredi</span><span>9:00 - 21:00</span></li>
                    <li><span>Samedi</span><span>9:00 - 17:00</span></li>
                    <li><span>Dimanche</span><span> fermé</span></li>
                </ul>
            </div>
            <div class="reseau">
                <h4>Réseaux sociaux</h4>
                <div>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-whatsapp"></i>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-bottom">
        <p>&copy; 2023. Tous droits réservés. Conçu par El kabdani soufiane</p>
    </div>
    <script src="options-rese.js"></script>
</body>
</html>
