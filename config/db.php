<?php
// Configurazione Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lobbyup');

// Connessione al database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Imposta charset UTF-8
$conn->set_charset("utf8mb4");

// Funzione helper per risposte JSON
function jsonResponse($success, $message, $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Funzione per pulire input
function cleanInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}
?>