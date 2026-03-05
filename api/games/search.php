<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

// Ottieni query di ricerca
$query = isset($_GET['query']) ? cleanInput($_GET['query']) : '';

if (strlen($query) < 3) {
    jsonResponse(false, 'Query troppo corta (min 3 caratteri)');
}

// Cerca nel database locale
$sql = "SELECT * FROM games WHERE name LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

$games = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
} else {
    // Mock data if database is empty for testing
    if (empty($games)) {
        $games = [
            ['id' => 1, 'name' => 'Fortnite', 'platform_id' => 1],
            ['id' => 2, 'name' => 'Call of Duty: Warzone', 'platform_id' => 2],
            ['id' => 3, 'name' => 'FIFA 24', 'platform_id' => 3],
            ['id' => 4, 'name' => 'Apex Legends', 'platform_id' => 4],
            ['id' => 5, 'name' => 'Minecraft', 'platform_id' => 5],
        ];
    }
}

jsonResponse(true, 'Giochi trovati', $games);

$conn->close();
?>