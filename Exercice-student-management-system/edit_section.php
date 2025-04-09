<?php
include 'auth.php'; 
include 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');

if (!$isAdmin) {
    die("Accès refusé.");
}

$id = $_GET['id'];
$query = "SELECT * FROM section WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$section = mysqli_fetch_assoc($result);

if (!$section) {
    die("Section introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "UPDATE section SET designation='$designation', description='$description' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: sections.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Modifier une Section</h2>
    
    <form method="POST">
        <div class="mb-3">
            <label for="designation" class="form-label">Désignation:</label>
            <input type="text" class="form-control" name="designation" value="<?= $section['designation'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" name="description" required><?= $section['description'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="sections.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

</body>
</html>
