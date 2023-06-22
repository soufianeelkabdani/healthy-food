<?php
session_start();
require_once('classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();
$id = $_GET["id"] ?? null;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="detail-admin.css">
    <script src="script.js"></script>
    <title>Détail-admin</title>
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

<section>
    <?php foreach ($nourritures as $nourriture) : ?>
        <div class="image-container">
            <img src="img/<?php echo $nourriture['_Image']; ?>">
        </div>
        <div class="content-container">
            <h1><?= $nourriture['Nom'] ?></h1>
            <h2 class="centered"><?= $nourriture['Sous_nom'] ?></h2>
            <p class="description"><?= $nourriture['Description_'] ?></p>
            <h3><?= $nourriture['Prix'] ?> DH</h3>
            <div class="buttons-container">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifierModal<?php echo $nourriture['Id_nourriture'] ?>">Modifier</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimerModal<?php echo $nourriture['Id_nourriture'] ?>">Supprimer</button>
            </div>
        </div>


    <!-- Modal de suppression -->
    <form method="post" action="includes/supprimer.inc.php" class="modal fade" id="supprimerModal<?php echo $nourriture['Id_nourriture'] ?>" tabindex="-1" aria-labelledby="supprimerModalLabel<?php echo $nourriture['Id_nourriture'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supprimerModalLabel<?php echo $nourriture['Id_nourriture'] ?>">Supprimer l'article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet article ?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="supprimer_id" value="<?php echo $nourriture['Id_nourriture'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </form>

        <div class="modal fade" id="modifierModal<?php echo $nourriture['Id_nourriture'] ?>" tabindex="-1" aria-labelledby="modifierModalLabel<?php echo $nourriture['Id_nourriture'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifierModalLabel<?php echo $nourriture['Id_nourriture'] ?>">Modifier l'article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/modifier.inc.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $nourriture['Id_nourriture'] ?>">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $nourriture['Nom'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="sous_nom" class="form-label">Sous-nom</label>
                                <input type="text" class="form-control" id="sous_nom" name="sous_nom" value="<?= $nourriture['Sous_nom'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"><?= $nourriture['Description_'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="prix" class="form-label">Prix</label>
                                <input type="text" class="form-control" id="prix" name="prix" value="<?= $nourriture['Prix'] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-enregistrer" name="modifier">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="options-rese.js"></script>
</body>
</html>
