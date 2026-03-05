<?php
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server - LobbyUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>

    <header class="container">
        <div class="logo">
            <a href="index.php">
                <div class="logo-icon">🎮</div>
                LobbyUp
            </a>
        </div>
        
        <div class="hamburger" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav id="main-nav">
            <ul>
                <li><a href="search.php">Cerca Sessioni</a></li>
                <li><a href="servers.php" class="active">Server</a></li>
                <li id="auth-links">
                    <a href="login.php" class="btn">Login</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container" style="margin-top: 40px; text-align: center;">
        <h2>Server della Community</h2>
        <p>Unisciti ai server tematici per discutere e organizzare partite.</p>
        
        <div class="card-grid">
            <div class="card">
                <h3>Lobby Generale</h3>
                <p>Il punto di ritrovo per tutti i gamer.</p>
                <button class="join-btn">ENTRA</button>
            </div>
            <div class="card">
                <h3>FPS Competitive</h3>
                <p>Per chi prende la mira sul serio.</p>
                <button class="join-btn">ENTRA</button>
            </div>
            <div class="card">
                <h3>RPG & Fantasy</h3>
                <p>Discussioni su lore, build e strategie.</p>
                <button class="join-btn">ENTRA</button>
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('main-nav').querySelector('ul').classList.toggle('active');
        }
    </script>
</body>
</html>
