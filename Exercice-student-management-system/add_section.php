<?php
include 'auth.php'; 
include 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');

if (!$isAdmin) {
    die("Accès refusé.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO section (designation, description) VALUES ('$designation', '$description')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: sections.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout de la section: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Ajouter une Section</h2>
    
    <form method="POST">
        <div class="mb-3">
            <label for="designation" class="form-label">Désignation:</label>
            <input type="text" class="form-control" name="designation" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="sections.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

</body>
</html>
