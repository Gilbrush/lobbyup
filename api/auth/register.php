<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

// Controlla se è una richiesta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Metodo non consentito');
}

// Ottieni i dati dal corpo della richiesta
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
    jsonResponse(false, 'Dati mancanti');
}

$username = cleanInput($data['username']);
$email = cleanInput($data['email']);
$password = $data['password'];

// Validazione base
if (strlen($username) < 3) {
    jsonResponse(false, 'Username troppo corto (min 3 caratteri)');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Email non valida');
}
if (strlen($password) < 6) {
    jsonResponse(false, 'Password troppo corta (min 6 caratteri)');
}

// Hash della password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Controlla se username o email esistono già
$sql_check = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    jsonResponse(false, 'Username o Email già registrati');
}

// Inserisci utente
$sql_insert = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$password_hash')";

if ($conn->query($sql_insert) === TRUE) {
    jsonResponse(true, 'Registrazione avvenuta con successo');
} else {
    jsonResponse(false, 'Errore durante la registrazione: ' . $conn->error);
}

$conn->close();
?>