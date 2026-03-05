<?php
// Configurazione RAWG API
define('RAWG_API_KEY', '4e580e0c90414999b6615c89304958f2'); // Demo key, replace if needed

require_once 'config/db.php';

// Funzione per ottenere giochi da RAWG con User-Agent
function fetchGamesFromRAWG($page = 1) {
    $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&page_size=20&page=" . $page;
    $options = [
        "http" => [
            "header" => "User-Agent: LobbyUp/1.0\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

// Funzione per mappare piattaforme RAWG alle nostre
function mapPlatform($rawg_platforms) {
    // Semplificazione: prendiamo la prima piattaforma compatibile
    foreach ($rawg_platforms as $p) {
        $slug = $p['platform']['slug'];
        if (strpos($slug, 'playstation') !== false) return 2; // PS5 (default)
        if (strpos($slug, 'xbox') !== false) return 1; // Xbox Series X
        if (strpos($slug, 'pc') !== false) return 3; // PC
        if (strpos($slug, 'nintendo') !== false) return 4; // Switch
    }
    return 3; // Default PC
}

echo "Iniziando importazione giochi da RAWG...\n";

// Svuota tabella giochi per evitare duplicati (in dev)
$conn->query("TRUNCATE TABLE games");
$conn->query("SET FOREIGN_KEY_CHECKS = 0"); 
// Nota: in produzione non fare TRUNCATE se ci sono sessioni collegate, ma qui stiamo rifacendo il seed

$data = fetchGamesFromRAWG(1);

if (isset($data['results'])) {
    $stmt = $conn->prepare("INSERT INTO games (name, igdb_id, cover_image, description, is_multiplayer, release_date) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($data['results'] as $game) {
        $name = $game['name'];
        $igdb_id = $game['slug']; // Usiamo lo slug di RAWG come ID univoco
        $cover_image = $game['background_image'];
        $description = "Rating: " . $game['rating'] . "/5. Genres: " . implode(", ", array_column($game['genres'], 'name'));
        $is_multiplayer = 1; // Assumiamo true per semplificare, RAWG ha tags per questo ma è complesso parsare
        $release_date = $game['released'];
        
        $stmt->bind_param("ssssis", $name, $igdb_id, $cover_image, $description, $is_multiplayer, $release_date);
        
        if ($stmt->execute()) {
            echo "Inserito: $name\n";
        } else {
            echo "Errore inserimento $name: " . $stmt->error . "\n";
        }
    }
    $stmt->close();
}

// Aggiungi Switch 2 manualmente se non esiste (RAWG potrebbe non averla ancora)
$conn->query("INSERT IGNORE INTO platforms (name, slug, logo_url) VALUES ('Nintendo Switch 2', 'nintendo-switch-2', 'https://upload.wikimedia.org/wikipedia/commons/0/04/Nintendo_Switch_logo%2C_square.png')");

echo "Importazione completata!";
?>