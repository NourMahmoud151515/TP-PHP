<?php
include 'db.php'; 
include 'Repository.php';

try {
    $sectionRepo = new Repository($conn, 'section'); 

    
    echo "<h3>All Sections:</h3>";
    $sections = $sectionRepo->findAll();
    print_r($sections);

  
    echo "<h3>Section with ID 1:</h3>";
    $section = $sectionRepo->findById(1);
    print_r($section);

   
    echo "<h3>Adding New Section...</h3>";
    $newSection = ['designation' => 'Informatique', 'description' => 'Section informatique'];
    $sectionRepo->create($newSection);
    echo "Section added successfully!";

  
    echo "<h3>Attempting to Delete Section ID 2...</h3>";
    $sectionExists = $sectionRepo->findById(2);

    if ($sectionExists) {
        $conn->query("DELETE FROM etudiants WHERE section_id = 2"); 
        $sectionRepo->delete(2);
        echo "Section deleted successfully!";
    } else {
        echo "Section not found or already deleted.";
    }

} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
