<?php
require_once 'config/db.php';
// Re-seed sessioni perché TRUNCATE games ha rotto le foreign keys o cancellato le sessioni
// ID giochi sono cambiati, dobbiamo prenderne alcuni validi
$result = $conn->query("SELECT id FROM games LIMIT 5");
$game_ids = [];
while($row = $result->fetch_assoc()) $game_ids[] = $row['id'];

// Utenti
$conn->query("INSERT IGNORE INTO users (id, username, email, password_hash, avatar_url) VALUES 
(1, 'ProGamer99', 'pro@lobbyup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://api.dicebear.com/7.x/avataaars/svg?seed=ProGamer99'),
(2, 'NerdGirl', 'nerd@lobbyup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://api.dicebear.com/7.x/avataaars/svg?seed=NerdGirl')");

// Sessioni
if (count($game_ids) >= 3) {
    $conn->query("INSERT INTO sessions (creator_id, game_id, platform_id, session_date, start_time, duration_hours, max_players, current_players, description, status) VALUES 
    (1, {$game_ids[0]}, 1, CURDATE(), '21:00:00', 2, 4, 1, 'Cerco team per vittoria BR Quartetti. No perditempo.', 'scheduled'),
    (2, {$game_ids[1]}, 2, CURDATE(), '22:30:00', 1, 11, 3, 'Relax e quest secondarie.', 'scheduled'),
    (1, {$game_ids[2]}, 3, CURDATE() + INTERVAL 1 DAY, '15:00:00', 4, 2, 1, 'Co-op puzzle solving, mic required.', 'scheduled')");
}

echo "Sessioni ripristinate.";
?>