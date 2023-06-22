<?php
session_start();
require_once('classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();



// Recherche
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM nourritures WHERE id_categorie = 1 AND (Nom LIKE '%$keyword%' OR Description_ LIKE '%$keyword%')";
    $result = $pdo->query($sql);
    $nourritures = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Pagination variables
    $itemsPerPage = 8;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $itemsPerPage;

    $stmt = $pdo->prepare("SELECT n.*, c.Nom_de_categorie FROM nourritures n INNER JOIN categories c ON n.id_categorie = c.id_categorie WHERE n.id_categorie = 3 LIMIT :offset, :itemsPerPage");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->execute(); // Exécuter la requête
    $nourritures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total items
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM nourritures WHERE id_categorie = 3");
    $stmt->execute();
    $totalItems = $stmt->fetchColumn();

    // Calculate total pages
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Generate pagination links
    $previousPage = max(1, $page - 1);
    $nextPage = min($totalPages, $page + 1);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="collation-uti.css">
    <title>Collation</title>
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
    
    <div class="container">
        <form class="banner-search" method="POST" action="repas.php">
            <input type="text" class="search-input" name="keyword" placeholder="Rechercher">
            <button class="search-button" type="submit" name="search"><i class="fas fa-search"></i></button>
        </form>
        <h2>Collation</h2>
        <?php if(count($nourritures) == 0): ?>
        <p style="text-align:center; font-size: 50px; padding-top: 90px">"Aucune nourriture n'a été trouvée !"</p>
        <?php else: ?>
        <div class="image-grid">
            <div class="image-row">
                <?php foreach ($nourritures as $nourriture) { ?>
                    <div class="image-item">
                        <img src="img/<?php echo $nourriture['_Image']; ?>">
                        <a href="detail.php?id=<?php echo $nourriture['Id_nourriture']; ?>"><span class="reservation-text"><?php echo $nourriture['Nom']; ?></span></a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $previousPage; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item <?php if ($page == $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $nextPage; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Footer -->
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
