<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

// Controlla se è una richiesta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Metodo non consentito');
}

// Ottieni i dati dal corpo della richiesta
$data = json_decode(file_get_contents("php://input"), true);

// Verifica token sessione (mock implementation)
// In un sistema reale, verificheremmo il token di autenticazione qui
$creator_id = isset($_SERVER['HTTP_X_USER_ID']) ? cleanInput($_SERVER['HTTP_X_USER_ID']) : 1; // Default to 1 for testing

if (!isset($data['game_id']) || !isset($data['platform_id']) || !isset($data['session_date']) || !isset($data['start_time']) || !isset($data['max_players'])) {
    jsonResponse(false, 'Dati mancanti');
}

$game_id = cleanInput($data['game_id']);
$platform_id = cleanInput($data['platform_id']);
$session_date = cleanInput($data['session_date']);
$start_time = cleanInput($data['start_time']);
$max_players = cleanInput($data['max_players']);
$description = isset($data['description']) ? cleanInput($data['description']) : '';

// Inserisci sessione
$sql = "INSERT INTO sessions (creator_id, game_id, platform_id, session_date, start_time, max_players, description) 
        VALUES ('$creator_id', '$game_id', '$platform_id', '$session_date', '$start_time', '$max_players', '$description')";

if ($conn->query($sql) === TRUE) {
    jsonResponse(true, 'Sessione creata con successo');
} else {
    jsonResponse(false, 'Errore durante la creazione: ' . $conn->error);
}

$conn->close();
?>