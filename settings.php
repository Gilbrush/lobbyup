<?php
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impostazioni - LobbyUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
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
                <li><a href="servers.php">Server</a></li>
                <li id="auth-links">
                    <a href="login.php" class="btn">Login</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container" style="margin-top: 40px; text-align: center;">
        <h2>Impostazioni Utente</h2>
        <div class="card" style="max-width: 500px; margin: 0 auto; text-align: left;">
            <div class="form-group">
                <label>Cambia Password</label>
                <input type="password" placeholder="Nuova password">
            </div>
            <div class="form-group">
                <label>Notifiche</label>
                <label><input type="checkbox"> Email</label>
                <label><input type="checkbox"> Push</label>
            </div>
            <button class="btn full-width">Salva</button>
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
