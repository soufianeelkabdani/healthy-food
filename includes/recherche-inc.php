<?php
require_once('classes/db.classes.php');
$db = new DB();
$pdo = $db->getPdo();


if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $totalItems = countSearchItems($keyword);
    $totalPages = ceil($totalItems / $perPage);
    $offset = ($page - 1) * $perPage;
    $results = searchItems($keyword, $offset, $perPage);
} else {
    // ...
}



function searchItems($keyword, $offset, $limit)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM nourritures WHERE Nom LIKE :keyword OR Sous_nom LIKE :keyword OR Description_ LIKE :keyword LIMIT :offset, :limit");
    $stmt->bindValue(':keyword', '%' . $keyword . '%');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function countSearchItems($keyword)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM nourritures WHERE Nom LIKE :keyword OR Sous_nom LIKE :keyword OR Description_ LIKE :keyword");
    $stmt->bindValue(':keyword', '%' . $keyword . '%');
    $stmt->execute();
    return $stmt->fetchColumn();
}
?>
