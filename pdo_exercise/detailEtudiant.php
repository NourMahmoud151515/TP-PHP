<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Étudiant non spécifié.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Étudiant introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Détails de l'étudiant</h2>
        <p><strong>Nom:</strong> <?= htmlspecialchars($student['name']) ?></p>
        <p><strong>Date de naissance:</strong> <?= htmlspecialchars($student['birthday']) ?></p>
        <a href="index.php" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>
