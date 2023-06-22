<?php
session_start(); 

require_once('classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();
$id = $_GET["id"] ?? null;

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['Id_utilisateur'])) {
    header("Location: login-regi.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Requête SQL pour récupérer les détails de la nourriture spécifique
$sql = "SELECT * FROM `nourritures` WHERE Id_nourriture = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$nourritures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="detail.css">
    <title>Détail</title>
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

    <section>
    <?php foreach ($nourritures as $nourriture) : ?>
    <div class="image-container">
        <img src="img/<?php echo $nourriture['_Image']; ?>" alt="">
    </div>
    <div class="content-container">
        <h1><?= $nourriture['Nom'] ?></h1>
        <h2 class="centered"><?= $nourriture['Sous_nom'] ?></h2>
        <p><?= $nourriture['Description_'] ?></p>
        <h3><?= $nourriture['Prix'] ?> DH</h3>
        <div class="reservation-container">
            <label for="quantity-input">Nombre de réservations:</label>
            <input type="number" id="quantity-input" min="1" value="1" data-prix="<?= $nourriture['Prix'] ?>" oninput="calculateTotal()">
        </div>
        <div id="total-amount"></div>
        <a href="#" data-toggle="modal" data-target="#reservationModal<?php echo $nourriture['Id_nourriture'] ?>">Réserver</a>
        </div>
        <?php endforeach; ?>
    </section>

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
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-instagram"></i>          
            <i class="fa-brands fa-whatsapp"></i>
        </div>
      </div>
    </div>
  </footer>
  <div class="footer-bottom">
    <p>&copy; 2023. Tous droits réservés. Conçu par El kabdani soufiane</p>
  </div>

<!-- Modal de confirmation -->
<div class="modal fade" id="reservationModal<?php echo $nourriture['Id_nourriture'] ?>" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">Confirmation de réservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous confirmer cette réservation ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-color" onclick="confirmReservation(<?php echo $nourriture['Id_nourriture']; ?>)">Confirmer</button>
            </div>
        </div>
    </div>
</div>
<div id="successModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reservation Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Reservation made successfully!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary to-status" data-bs-dismiss="modal" style="background-color: #f34949">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
<script src="options-rese.js"></script>
</body>
</html>