<?php
include 'auth.php'; 
include 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');

if (!$isAdmin) {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $date_naissance = mysqli_real_escape_string($conn, $_POST['date_naissance']);
    $section_id = mysqli_real_escape_string($conn, $_POST['section_id']);

    
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target_dir = "assets/images/";
    $target_file = $target_dir . basename($image_name);

    if (!empty($image_name) && move_uploaded_file($image_tmp, $target_file)) {
        $query = "INSERT INTO etudiants (nom, prenom, email, date_naissance, section_id, image) 
                  VALUES ('$nom', '$prenom', '$email', '$date_naissance', '$section_id', '$image_name')";
    
        if (mysqli_query($conn, $query)) {
            header("Location: students.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout de l'étudiant: " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors du téléchargement de l'image. Vérifiez que le fichier est valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Ajouter un étudiant</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom:</label>
            <input type="text" class="form-control" name="nom" required>
        </div>
        
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom:</label>
            <input type="text" class="form-control" name="prenom" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance:</label>
            <input type="date" class="form-control" name="date_naissance" required>
        </div>

        <div class="mb-3">
            <label for="section_id" class="form-label">Section:</label>
            <select class="form-select" name="section_id">
                <?php
                $sections = mysqli_query($conn, "SELECT * FROM section");
                while ($section = mysqli_fetch_assoc($sections)) {
                    echo "<option value='{$section['id']}'>{$section['designation']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" name="image" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="students.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

</body>
</html>
