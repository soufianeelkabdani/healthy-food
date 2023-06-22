<?php
session_start();

require_once('classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();

// Prepare the search query
$searchQuery = "SELECT n.*, c.Nom_de_categorie 
                FROM nourritures n 
                INNER JOIN categories c ON n.id_categorie = c.id_categorie 
                WHERE c.id_categorie = 2 ";

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $searchQuery .= "AND (n.Nom LIKE :search OR n.Description_ LIKE :search) ";
}

$searchQuery .= "LIMIT :offset, :itemsPerPage";

// Pagination variables
$itemsPerPage = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$stmt = $pdo->prepare($searchQuery);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
if (!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%');
}
$stmt->execute();
$nourritures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total items
$countQuery = "SELECT COUNT(*) as total 
                FROM nourritures n 
                INNER JOIN categories c ON n.id_categorie = c.id_categorie 
                WHERE c.id_categorie = 2 ";
if (!empty($search)) {
    $countQuery .= "AND (n.Nom LIKE :search OR n.Description_ LIKE :search) ";
}

$countStmt = $pdo->prepare($countQuery);
if (!empty($search)) {
    $countStmt->bindValue(':search', '%' . $search . '%');
}
$countStmt->execute();
$totalItems = $countStmt->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Generate pagination links
$previousPage = max(1, $page - 1);
$nextPage = min($totalPages, $page + 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dejeuner.css">
    <title>Déjeuner</title>
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
        <form class="banner-search" action="" method="get">
            <input type="text" class="search-input" name="search" placeholder="Rechercher" value="<?php echo $search; ?>">
            <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
        </form>
    <div class="container">
        <button class="ajouter-btn btn btn-custom" data-bs-toggle="modal" data-bs-target="#myModal">AJOUTER</button>
        <h2>Déjeuner</h2>
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
                <li class="aria-hidden"  class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item <?php if ($page == $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $nextPage; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
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

<!-------------------------------------------- Modal -------------------->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Ajouter un élément</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" action="includes/repas-dej.inc.php">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom">
          </div>
          <div class="mb-3">
            <label for="sous-nom" class="form-label">Sous-nom</label>
            <input type="text" class="form-control" id="sous-nom" name="sous-nom">
          </div>
          <div class="mb-3">
            <label for="importation-images" class="form-label">Importation des images</label>
            <input type="file" class="form-control" id="importation-images" name="importation-images">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="text" class="form-control" id="prix" name="prix">
          </div>
          <div class="mb-3">
            <label for="categories" class="form-label">Nombre de catégories</label>
            <select class="form-select" id="categories" name="categories">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-custom" name="submit">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<script src="options-rese.js"></script>
</body>
</html>
