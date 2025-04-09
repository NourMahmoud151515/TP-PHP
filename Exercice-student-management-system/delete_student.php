<?php
include 'auth.php'; 
include 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');

if (!$isAdmin) {
    die("Accès refusé.");
}

$id = $_GET['id'];

$query = "DELETE FROM etudiants WHERE id = '$id'";
mysqli_query($conn, $query);

header("Location: students.php");
exit();
?>
