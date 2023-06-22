<?php
session_start(); // Ajoutez cette ligne pour démarrer la session

require_once('classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();

// Récupérez l'ID de l'utilisateur connecté à partir de la session
$id_utilisateur = $_SESSION['Id_utilisateur'];

// Requête SQL pour récupérer la dernière réservation confirmée par l'administrateur
$sqlDerniereReservation = "SELECT c.*, n.Nom, n.Sous_nom, n.Description_, n._Image
                           FROM commander AS c
                           INNER JOIN nourritures AS n ON c.Id_nourriture = n.Id_nourriture
                           WHERE c.Id_utilisateur = :id_utilisateur
                           ORDER BY c.Id_commande DESC -- Récupérer la dernière réservation
                           LIMIT 1";

// Préparation de la requête pour la dernière réservation
$stmtDerniereReservation = $pdo->prepare($sqlDerniereReservation);
$stmtDerniereReservation->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
$stmtDerniereReservation->execute();

// Récupération de la dernière réservation
$derniereReservation = $stmtDerniereReservation->fetch(PDO::FETCH_ASSOC);

// Définir le nombre d'éléments à afficher par page
$elementsParPage = 5;

// Récupérer le numéro de page à partir des paramètres de l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculer l'offset pour la requête SQL
$offset = ($page - 1) * $elementsParPage;

// Requête SQL pour récupérer les détails des commandes de l'utilisateur avec pagination
$sql = "SELECT c.*, n.Nom, n.Sous_nom, n.Description_, n._Image
        FROM commander AS c
        INNER JOIN nourritures AS n ON c.Id_nourriture = n.Id_nourriture
        WHERE c.Id_utilisateur = :id_utilisateur
        ORDER BY c.Date_de_commande DESC -- Appliquer le tri par date de commande (ordre décroissant)
        LIMIT :offset, :elementsParPage";

// Préparation de la requête
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':elementsParPage', $elementsParPage, PDO::PARAM_INT);

// Exécution de la requête
$stmt->execute();

// Récupération des résultats de la requête
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compter le nombre total de commandes de l'utilisateur
$sqlCount = "SELECT COUNT(*) AS total FROM commander WHERE Id_utilisateur = :id_utilisateur";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
$stmtCount->execute();
$totalCommandes = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];

// Calculer le nombre total de pages
$totalPages = ceil($totalCommandes / $elementsParPage);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="status.css">
    <title>Status</title>
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

<?php if (empty($commandes)) : ?>
    <p style="text-align:center; font-size: 50px; padding-top: 90px">Aucune commande trouvée.</p>
<?php else : ?>
    <?php foreach ($commandes as $commande) : ?>
        <section>
            <img src="img/<?php echo $commande['_Image']; ?>" alt="" width="200">
            <div>
                <h3><span><?php echo $commande['Nom']; ?></span><br><?php echo $commande['Sous_nom']; ?></h3>
                <p>
                    <?php echo $commande['Description_']; ?>
                </p>
            </div>
            <div class="price">
                <h3><?php echo $commande['Montant_de_commande']; ?> DH</h3>
            </div>
            <div class="status">
                <p><?php echo $commande['Status']; ?></p>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <li class="page-item <?php if ($page == $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>

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
<script src="options-rese.js"></script>
</body>
</html>
