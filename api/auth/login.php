<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

// Controlla se è una richiesta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Metodo non consentito');
}

// Ottieni i dati dal corpo della richiesta
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    jsonResponse(false, 'Dati mancanti');
}

$email = cleanInput($data['email']);
$password = $data['password'];

// Cerca utente per email
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verifica password
    if (password_verify($password, $user['password_hash'])) {
        // Genera token (in un sistema reale userei JWT o sessioni sicure)
        $token = bin2hex(random_bytes(32));
        
        // Aggiorna ultimo login
        $sql_update = "UPDATE users SET last_login = NOW() WHERE id = " . $user['id'];
        $conn->query($sql_update);
        
        // Rimuovi hash password dalla risposta
        unset($user['password_hash']);
        
        jsonResponse(true, 'Login effettuato con successo', [
            'token' => $token,
            'user' => $user
        ]);
    } else {
        jsonResponse(false, 'Credenziali non valide');
    }
} else {
    jsonResponse(false, 'Utente non trovato');
}

$conn->close();
?>