<?php
include 'auth.php'; 
include 'db.php';

$id = $_GET['id'];
$query = "SELECT * FROM section WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$section = mysqli_fetch_assoc($result);

if (!$section) {
    die("Section introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Détails de la Section</h2>
    <p><strong>Désignation:</strong> <?= $section['designation'] ?></p>
    <p><strong>Description:</strong> <?= $section['description'] ?></p>
    <a href="sections.php" class="btn btn-secondary">Retour</a>
</div>

</body>
</html>
