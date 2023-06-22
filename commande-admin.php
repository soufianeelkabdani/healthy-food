<?php
session_start();



require_once 'classes/db.classes.php';
$db = new DB();
$pdo = $db->getPdo();

// Pagination
$limit = 10; // Nombre d'éléments par page
$pageCourante = isset($_GET['page']) ? $_GET['page'] : 1; // Page courante, par défaut 1
$offset = ($pageCourante - 1) * $limit; // Offset pour la requête SQL

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Terme de recherche

// Requête SQL
$sql = "SELECT c.*, u.Nom_, u.Prenom, u.Adresse, u.Numero_telephone, u.Email, n.Nom, n.Sous_nom, n.Description_, n._Image AS Nom_nourriture
FROM commander c
INNER JOIN utilisateurs u ON c.Id_utilisateur = u.Id_utilisateur
INNER JOIN nourritures n ON c.Id_nourriture = n.Id_nourriture
WHERE (u.Nom_ LIKE :search OR u.Prenom LIKE :search)
AND c.status = 'En cours de traitement';
";

// Compter le nombre total d'éléments pour la pagination
$stmtCount = $pdo->prepare($sql);
$stmtCount->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmtCount->execute();
$totalElements = $stmtCount->rowCount();

// Calculer le nombre total de pages
$totalPages = ceil($totalElements / $limit);

// Requête SQL avec pagination et recherche
$sql .= " LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="commande-admin.css">
    <title>Réservation</title>
</head>
<body>
<nav class="nav-header">
    <ul>
        <li>
            <a href="#" onclick="toggleOptions()">REPAS</a>
            <ul id="options" class="options">
                <li><a href="repas-admin.php">Nourritures saines</a></li>
                <li><a href="petit-dejeuner.php">Petit-déjeuner</a></li>
                <li><a href="dejeuner.php">Déjeuner</a></li>
                <li><a href="collation.php">Collation</a></li>
                <li><a href="diner.php">Dîner</a></li>
            </ul>
        </li>
        <li>
            <a href="commande-admin.php">COMMANDE</a>
        </li>
    </ul>
    <img src="img/logo.png" alt="logo" width="200" height="100">
    <ul>
        <li>
            <a href="livraison-admin.php">LIVRAISON</a>
        </li>
        <li>
            <a href="classes/logout.classes.php">DECONNEXION</a>
        </li>
    </ul>
</nav>

<form class="banner-search" action="" method="get">
    <input type="text" class="search-input" name="search" placeholder="Rechercher" value="<?php echo $search; ?>">
    <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
</form>

<?php if (empty($commandes)) : ?>
    <p style="font-weight: bold; text-align: center; font-size: 70px;">Aucune commande !</p>
<?php else : ?>
    <?php foreach ($commandes as $commande) : ?>
        <section id="commande-<?php echo $commande['Id_commande']; ?>">
            <img src="img/<?php echo $commande['Nom_nourriture']; ?>" alt="" width="200">
            <div>
                <h3><span><?php echo $commande['Nom']; ?></span><br> <?php echo $commande['Sous_nom']; ?></h3>
                <p class="description"><?php echo $commande['Description_']; ?></p>
            </div>
            <div class="price">
                <h3><?php echo $commande['Montant_de_commande']; ?>DH</h3>
                <p>Nombre de réservation : <?php echo $commande['Nombre_de_commande']; ?></p>
            </div>
            <div class="contact-info">
                <p><?php echo $commande['Nom_']; ?></p>
                <p><?php echo $commande['Prenom']; ?></p>
                <p><?php echo $commande['Adresse']; ?></p>
                <p><?php echo $commande['Numero_telephone']; ?></p>
                <p><?php echo $commande['Email']; ?></p>
            </div>
            <div class="buttons">
            <p><?php echo $commande['Date_de_commande']; ?></p>
            <form action="includes/confirme-commande.inc.php" method="post">
                <button class="confirm-button" type="submit" name="confirmer" data-commande-id="<?php echo $commande['Id_commande']; ?>">Confirmer</button>
                <input type="hidden" name="commande-id" value="<?php echo $commande['Id_commande']; ?>">
                <input type="hidden" name="Id_utilisateur" value="<?php echo $commande['Id_utilisateur']; ?>">

            </form>
            <input type="hidden" class="success-message" value="La commande a été confirmée avec succès.">
            <form action="includes/supprime-commande.inc.php" method="post">
                <input type="hidden" name="commande-id" value="<?php echo $commande['Id_commande']; ?>">
                <button class="delete-button" type="submit" name="delete-button">Supprimer</button>
            </form>
        </div>
    </section>
<?php endforeach; ?>
<?php endif; ?>

<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($pageCourante == 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $pageCourante - 1; ?>&search=<?php echo $search; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="aria-hidden"  class="page-item <?php echo ($i == $pageCourante) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($pageCourante == $totalPages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $pageCourante + 1; ?>&search=<?php echo $search; ?>" aria-label="Next">
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
<script src="confirme-commande.js"></script>


</body>
</html>
