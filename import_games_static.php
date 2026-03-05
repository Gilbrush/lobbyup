<?php
// Usiamo i dati JSON statici per simulare RAWG dato che le chiavi API pubbliche sono limitate/scadute
// In produzione, sostituire con chiamate API reali
require_once 'config/db.php';

echo "Iniziando importazione giochi da dati statici...\n";

// Svuota tabella giochi
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("TRUNCATE TABLE games");

// Dati simulati arricchiti (Top 20 giochi)
$games = [
    [
        "name" => "Grand Theft Auto V",
        "slug" => "grand-theft-auto-v",
        "background_image" => "https://media.rawg.io/media/games/456/456dea5e1c7e3cd07060c14e96612001.jpg",
        "rating" => 4.47,
        "released" => "2013-09-17",
        "genres" => "Action, Adventure"
    ],
    [
        "name" => "The Witcher 3: Wild Hunt",
        "slug" => "the-witcher-3-wild-hunt",
        "background_image" => "https://media.rawg.io/media/games/618/618c2031a07bbff6b4f611f10b6bcdbc.jpg",
        "rating" => 4.66,
        "released" => "2015-05-18",
        "genres" => "Action, RPG"
    ],
    [
        "name" => "Portal 2",
        "slug" => "portal-2",
        "background_image" => "https://media.rawg.io/media/games/328/3283617cb7d75d67257fc58332788f1e.jpg",
        "rating" => 4.61,
        "released" => "2011-04-18",
        "genres" => "Shooter, Puzzle"
    ],
    [
        "name" => "Counter-Strike: Global Offensive",
        "slug" => "counter-strike-global-offensive",
        "background_image" => "https://media.rawg.io/media/games/736/73619bd336c894d6941d926bfd563946.jpg",
        "rating" => 3.57,
        "released" => "2012-08-21",
        "genres" => "Shooter, Action"
    ],
    [
        "name" => "Baldur's Gate 3",
        "slug" => "baldurs-gate-3",
        "background_image" => "https://media.rawg.io/media/games/d5a/d5a24f9f71315427fa6e966fdd98dfa6.jpg",
        "rating" => 4.5,
        "released" => "2023-08-03",
        "genres" => "RPG, Strategy"
    ],
    [
        "name" => "Elden Ring",
        "slug" => "elden-ring",
        "background_image" => "https://media.rawg.io/media/games/b29/b294fdd866dcdb643e7bab370a552855.jpg",
        "rating" => 4.4,
        "released" => "2022-02-25",
        "genres" => "Action, RPG"
    ],
    [
        "name" => "Minecraft",
        "slug" => "minecraft",
        "background_image" => "https://media.rawg.io/media/games/b4e/b4e4c73d5aa4ec66bbf75375c4847a2b.jpg",
        "rating" => 4.4,
        "released" => "2011-11-18",
        "genres" => "Simulation, Arcade"
    ],
    [
        "name" => "Fortnite",
        "slug" => "fortnite",
        "background_image" => "https://media.rawg.io/media/games/d1a/d1a2e99ade53494c6330a0ed945fe823.jpg",
        "rating" => 3.0,
        "released" => "2017-07-21",
        "genres" => "Action, Shooter"
    ],
    [
        "name" => "Call of Duty: Modern Warfare II",
        "slug" => "call-of-duty-modern-warfare-ii",
        "background_image" => "https://media.rawg.io/media/games/f87/f87457e8347484033cb34cde6101d08d.jpg",
        "rating" => 3.5,
        "released" => "2022-10-28",
        "genres" => "Action, Shooter"
    ],
    [
        "name" => "Apex Legends",
        "slug" => "apex-legends",
        "background_image" => "https://media.rawg.io/media/games/b72/b7233d5d5b1e75e86bb860ccc7aeca85.jpg",
        "rating" => 3.6,
        "released" => "2019-02-04",
        "genres" => "Action, Shooter"
    ],
    [
        "name" => "Cyberpunk 2077",
        "slug" => "cyberpunk-2077",
        "background_image" => "https://media.rawg.io/media/games/26d/26d4437715bee60138dab4a7c8c59c92.jpg",
        "rating" => 4.1,
        "released" => "2020-12-10",
        "genres" => "Action, RPG"
    ],
    [
        "name" => "Red Dead Redemption 2",
        "slug" => "red-dead-redemption-2",
        "background_image" => "https://media.rawg.io/media/games/511/5118aff5091cb3efec399c808f8c598f.jpg",
        "rating" => 4.6,
        "released" => "2018-10-26",
        "genres" => "Action, Adventure"
    ],
    [
        "name" => "Rocket League",
        "slug" => "rocket-league",
        "background_image" => "https://media.rawg.io/media/games/8cc/8cce7c0e99dcc43d66c8efd42f9d03e3.jpg",
        "rating" => 4.0,
        "released" => "2015-07-07",
        "genres" => "Sports, Racing"
    ],
    [
        "name" => "FIFA 23",
        "slug" => "fifa-23",
        "background_image" => "https://media.rawg.io/media/games/123/123123123.jpg", // Placeholder
        "rating" => 3.2,
        "released" => "2022-09-30",
        "genres" => "Sports"
    ],
    [
        "name" => "Valorant",
        "slug" => "valorant",
        "background_image" => "https://media.rawg.io/media/games/b11/b115b2bc6a5957a917bc7601f4abdda2.jpg",
        "rating" => 3.8,
        "released" => "2020-06-02",
        "genres" => "Action, Shooter"
    ]
];

$stmt = $conn->prepare("INSERT INTO games (name, igdb_id, cover_image, description, is_multiplayer, release_date) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($games as $game) {
    $name = $game['name'];
    $igdb_id = $game['slug'];
    $cover_image = $game['background_image'];
    $description = "Rating: " . $game['rating'] . "/5. Genres: " . $game['genres'];
    $is_multiplayer = 1;
    $release_date = $game['released'];
    
    $stmt->bind_param("ssssis", $name, $igdb_id, $cover_image, $description, $is_multiplayer, $release_date);
    
    if ($stmt->execute()) {
        echo "Inserito: $name\n";
    } else {
        echo "Errore inserimento $name: " . $stmt->error . "\n";
    }
}
$stmt->close();

// Aggiungi Switch 2 e aggiorna altre piattaforme
$conn->query("INSERT IGNORE INTO platforms (name, slug, logo_url) VALUES ('Nintendo Switch 2', 'nintendo-switch-2', 'https://upload.wikimedia.org/wikipedia/commons/0/04/Nintendo_Switch_logo%2C_square.png')");
$conn->query("UPDATE platforms SET logo_url = 'https://upload.wikimedia.org/wikipedia/commons/8/83/Steam_icon_logo.svg' WHERE slug = 'pc-steam' OR slug = 'pc'");

echo "Importazione completata!";
?>