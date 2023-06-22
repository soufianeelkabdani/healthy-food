<?php
session_start();
require_once 'classes/db.classes.php';
$db = new DB();
$pdo = $db->getPdo();
$sql = "SELECT * FROM `nourritures` LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$nourriture = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['admin']) &&  $_SESSION['admin'] == 1) {

    header('location: repas-admin.php');    
    exit();
} else if(!isset($_SESSION['admin'])) {
    header('location: login-regi.php');
    exit();
}else {

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Accueil</title>
</head>
<body>
     <!----------------------------------------------------------------------------------------Navbar ------------------------------------------------------------------->
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

<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<section class="banner-section">
    <div class="banner-content">
        <h1 class="banner-title">Nourrissez votre corps pour une vie épanouie !</h1>

        <div class="banner-button">
            <a href="repas.php" class="reservation-button" role="button">Réserver</a>
        </div>

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
<section class="main-section">
    <div class="main-content">
        <div class="image">
            <img src="img/hero-1.jpg" alt="">
        </div>
        <div class="text">
            <div class="title">
                <h2> A PROPOS DE NOUS</h2>
            </div>
            <div class="description">
                <p>
                    Chez HEALTHY FOOD, nous sommes passionnés par la promotion d'un mode de vie sain et équilibré à travers la cuisine. Notre mission est d'inspirer les individus à prendre soin de leur corps et de leur bien-être en leur offrant des recettes culinaires nutritives et délicieuses.
                    Nous croyons fermement que la nourriture est bien plus qu'une simple nécessité quotidienne. Elle est une source de joie, de plaisir et de vitalité. C'est pourquoi nous nous sommes engagés à créer une plateforme qui met en avant des recettes saines et équilibrées, mettant en valeur des ingrédients de qualité et des techniques de préparation bénéfiques pour la santé.
                    Notre équipe de passionnés de la cuisine et de la nutrition travaille sans relâche pour vous offrir des recettes variées, allant des petits-déjeuners énergisants aux dîners savoureux, des collations saines aux desserts gourmands. Nous nous efforçons de rendre la cuisine saine accessible à tous, quels que soient les régimes alimentaires, les préférences ou les restrictions.
                    Bienvenue dans l'univers de HEALTHY FOOD, où nous célébrons la santé, la gourmandise et le bien-être à chaque bouchée.
                </p>
            </div>
        </div>
    </div>
</section>
<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<section class="Nouvelle-nourriture">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="heading-section mb-5 mt-5 text-center">
                <h2>Nouvelle saine</h2>
            </div>
        </div>
    </div>
    <div class="contenu-saine">
        <div>
            <img src="img/<?php echo $nourriture['_Image']; ?>" alt="" class="img-fluid shadow" style="width: 100%; max-width: 550px;">
        </div>
        <div class="Nouvelle-nourriture-text text-center">
            <h3><span><?php echo $nourriture['Nom']; ?></span><br><?php echo $nourriture['Sous_nom']; ?></h3>
            <p><?php echo $nourriture['Description_']; ?></p>
            <h3 id="prix-nouvelle-saine"><?php echo $nourriture['Prix']; ?> DH</h3>
            <a href="detail.php?id=<?php echo $nourriture['Id_nourriture']; ?>" class="reservation-button" role="button">Réserver</a>        </div>
    </div>
</section>



<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<div class="section-content">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="heading-section text-center mb-5">
                <h2 class="text-center">Client</h2>
            </div>
        </div>
    </div>

<div id="clientCarousel" class="carousel slide carousel-container" data-ride="carousel">
    <!-- Indicateurs -->
    <ol class="carousel-indicators">
        <li data-target="#clientCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#clientCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Slides -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <i class="client-icon fa fa-3x fa-quote-left"></i>
            <p class="client-author">Soufiane :</p>
            <p class="client-text">“ Les repas de healthy food ont révolutionné ma vie ! Leurs délicieux plats préparés avec soin et expertise ont comblé mes papilles tout en facilitant mon engagement envers une alimentation saine. Chaque bouchée est un véritable festin de saveurs équilibrées et nourrissantes. Je suis constamment impressionné par la qualité des ingrédients utilisés, leur fraîcheur et leur provenance soigneusement sélectionnée “</p>
        </div>
        <div class="carousel-item">
            <i class="testi-icon fa fa-3x fa-quote-left"></i>
            <p class="client-author">Ali :</p>
            <p class="client-text">Je tenais absolument à partager mon expérience d'achat sur cette fantastique plateforme de vente de nourritures saines. En tant que personne soucieuse de ma santé et de mon bien-être, je suis toujours à la recherche de produits qui peuvent nourrir mon corps de manière saine et délicieuse. Et je dois dire que cette plateforme a parfaitement répondu à toutes mes attentes !</p>
        </div>
    </div>

    <!-- Contrôles -->
    <a class="carousel-control-prev" href="#clientCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Précédent</span>
    </a>
    <a class="carousel-control-next" href="#clientCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Suivant</span>
    </a>
</div>
<!-----------------------------------------------------------------------------------------------------------------fin --------------------------------------------------->
<section class="equipe">
    <div class="equipe-content">
        <div class="section-content">
            <div class="heading-section text-center pt-lg-5 mb-5">
                <h2>Equipe</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="equipe-card mb-5">
                        <img class="img-fluid" src="img/chef soufiane.jpg" alt="">
                        <div class="equipe-desc">
                            <h4 class="mb-0">Chef Soufiane</h4>
                            <p class="mb-1">Diplômé de l’école hôtelière de Genève et avec quatorze ans d'expérience professionnelle en Suisse à son actif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="equipe-card mb-5">
                        <img class="img-fluid" src="img/chef outhman.jpg" alt="">
                        <div class="equipe-desc">
                            <h4 class="mb-0">Chef Outhman</h4>
                            <p class="mb-1">Formé aux grandes écoles d’hôtellerie et de cuisine en France, et ayant eu des expériences auprès des plus grands chefs de la gastronomie française.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="equipe-card mb-5">
                        <img class="img-fluid" src="img/chef mounia.jpg" alt="">
                        <div class="equipe-desc">
                            <h4 class="mb-0">Chef Mounia</h4>
                            <p class="mb-1">Lauréate de l'École de tourisme et d'hôtellerie de Marrakech. Elle a officié en tant que professeur à l'École hôtelière de Fès.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
<?php 
}
?>