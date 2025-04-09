<?php
include 'auth.php'; 
include 'db.php';

$id = $_GET['id'];
$query = "SELECT e.*, s.designation FROM etudiants e JOIN section s ON e.section_id = s.id WHERE e.id = '$id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("Étudiant introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Détails de l'Étudiant</h2>
    <img src="assets/images/<?= $student['image'] ?>" width="150"><br>
    <p><strong>Nom:</strong> <?= $student['nom'] ?></p>
    <p><strong>Prénom:</strong> <?= $student['prenom'] ?></p>
    <p><strong>Email:</strong> <?= $student['email'] ?></p>
    <p><strong>Date de naissance:</strong> <?= $student['date_naissance'] ?></p>
    <p><strong>Section:</strong> <?= $student['designation'] ?></p>
    <a href="students.php" class="btn btn-secondary">Retour</a>
</div>

</body>
</html>
