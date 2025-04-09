<?php
include 'auth.php'; 
include 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');

if (!$isAdmin) {
    die("Accès refusé.");
}

$id = $_GET['id'];

$query = "DELETE FROM section WHERE id = '$id'";
mysqli_query($conn, $query);

header("Location: sections.php");
exit();
?>
