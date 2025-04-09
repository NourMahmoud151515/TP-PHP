<?php
include 'auth.php'; 
include 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');

if (!$isAdmin) {
    die("Accès refusé.");
}

$id = $_GET['id'];
$query = "SELECT * FROM etudiants WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("Étudiant introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $date_naissance = mysqli_real_escape_string($conn, $_POST['date_naissance']);
    $section_id = mysqli_real_escape_string($conn, $_POST['section_id']);

    
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($image_name);
        move_uploaded_file($image_tmp, $target_file);
    } else {
        $image_name = $student['image']; 
    }

    $query = "UPDATE etudiants SET nom='$nom', prenom='$prenom', email='$email', date_naissance='$date_naissance', section_id='$section_id', image='$image_name' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: students.php");
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
    <title>Modifier un Étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Modifier un Étudiant</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <img src="assets/images/<?= $student['image'] ?>" width="150"><br>
        
        <div class="mb-3">
            <label for="nom" class="form-label">Nom:</label>
            <input type="text" class="form-control" name="nom" value="<?= $student['nom'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom:</label>
            <input type="text" class="form-control" name="prenom" value="<?= $student['prenom'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="<?= $student['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance:</label>
            <input type="date" class="form-control" name="date_naissance" value="<?= $student['date_naissance'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="section_id" class="form-label">Section:</label>
            <select class="form-select" name="section_id">
                <?php
                $sections = mysqli_query($conn, "SELECT * FROM section");
                while ($section = mysqli_fetch_assoc($sections)) {
                    $selected = ($section['id'] == $student['section_id']) ? 'selected' : '';
                    echo "<option value='{$section['id']}' $selected>{$section['designation']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Nouvelle Image:</label>
            <input type="file" class="form-control" name="image">
        </div>

        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="students.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

</body>
</html>
