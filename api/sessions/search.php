<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

// Ottieni i parametri GET
$game_id = isset($_GET['game_id']) ? cleanInput($_GET['game_id']) : null;
$platform_id = isset($_GET['platform_id']) ? cleanInput($_GET['platform_id']) : null;
$date = isset($_GET['date']) ? cleanInput($_GET['date']) : null;

// Costruisci query
$sql = "SELECT s.*, g.name AS game_name, p.name AS platform_name, u.username AS creator_name 
        FROM sessions s 
        JOIN games g ON s.game_id = g.id 
        JOIN platforms p ON s.platform_id = p.id 
        JOIN users u ON s.creator_id = u.id 
        WHERE 1=1";

if ($game_id) {
    $sql .= " AND s.game_id = '$game_id'";
}
if ($platform_id) {
    $sql .= " AND s.platform_id = '$platform_id'";
}
if ($date) {
    $sql .= " AND s.session_date = '$date'";
}

$sql .= " ORDER BY s.session_date ASC, s.start_time ASC LIMIT 20";

$result = $conn->query($sql);

$sessions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
}

jsonResponse(true, 'Sessioni trovate', $sessions);

$conn->close();
?>