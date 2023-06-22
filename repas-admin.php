<?php
session_start();
include 'classes/db.classes.php';

$db = new DB();
$conn = $db->getPdo();



// Effectuer la requête SQL pour récupérer les données de la table "nourritures"
$sql = "SELECT * FROM nourritures";
$result = $conn->query($sql);
$nourritures = $result->fetchAll(PDO::FETCH_ASSOC);

// Pagination
$perPage = 16; // Nombre d'éléments à afficher par page
$totalItems = count($nourritures);
$totalPages = ceil($totalItems / $perPage); // Calculer le nombre total de pages
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Récupérer le numéro de page actuel

$offset = ($page - 1) * $perPage; // Calculer l'offset pour la requête SQL
$sql .= " LIMIT $offset, $perPage";
$result = $conn->query($sql);
$nourritures = $result->fetchAll(PDO::FETCH_ASSOC);

// Recherche
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM nourritures WHERE Nom LIKE '%$keyword%' OR Description_ LIKE '%$keyword%'";
    $result = $conn->query($sql);
    $nourritures = $result->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="repas-admin.css">
    <title>Repas</title>
</head>
<body>
       <!----------------------------------------------------------------------------------------Navbar ------------------------------------------------------------------->
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
<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<section class="banner-section">
    <div class="banner-content">
        <h1 class="banner-title">Nourrissez votre corps pour une vie épanouie !</h1>

        <form class="banner-search" method="POST" action="repas-admin.php">
            <input type="text" class="search-input" name="keyword" placeholder="Rechercher">
            <button class="search-button" type="submit" name="search"><i class="fas fa-search"></i></button>
        </form>

        <ul class="banner-info-list">
            <li class="banner-info-item">
                <span class="banner-info-icon">
                    <i class="fas fa-truck"></i> 
                </span>
                <h5 class="banner-info-text">
                    Livraison <br> rapide
                </h5>
            </li>
            <li class="banner-info-item">
                <span class="banner-info-icon">
                    <i class="fas fa-utensils"></i> 
                </span>
                <h5 class="banner-info-text">
                    Nourriture <br> fraîche
                </h5>
            </li>
            <li class="banner-info-item">
                <span class="banner-info-icon">
                    <i class="fas fa-headset"></i> 
                </span>
                <h5 class="banner-info-text">
                    Assistance <br> 24/7
                </h5>
            </li>
        </ul>
    </div>
    <div class="banner-images">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="banner-image" src="img/Flocons d'avoine à la banane.png" alt="">
                </div>
                <div class="carousel-item">
                    <img class="banner-image" src="img/Salade de noix de cajou.png" alt="">
                </div>
                <div class="carousel-item">
                    <img class="banner-image" src="img/Framboises.png" alt="">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>
<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<div class="container">
    <h2>Nourritures saines</h2>
    <?php if(count($nourritures) == 0): ?>
        <p style="text-align:center; font-size: 50px; padding-top: 90px">"Aucune nourriture n'a été trouvée !"</p>
    <?php else: ?>
    <div class="image-grid">
        <div class="image-row">
            <?php foreach ($nourritures as $nourriture) { ?>
                <div class="image-item">
                    <img src="img/<?php echo $nourriture['_Image']; ?>">
                    <a href="detail-admin.php?id=<?php echo $nourriture['Id_nourriture']; ?>"><span class="reservation-text"><?php echo $nourriture['Nom']; ?></span></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                <span class="aria-hidden-color" aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="aria-hidden" class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <li class="page-item <?php if ($page == $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                <span class="aria-hidden-color" class="aria-hidden-color" aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>


<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="options-rese.js"></script>
</body>
</html>