<?php
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente - LobbyUp</title>
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
        <h2>Profilo Utente</h2>
        <div id="profile-content">
            <p>Caricamento profilo...</p>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('main-nav').querySelector('ul').classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const user = JSON.parse(localStorage.getItem('user'));
            if (!user) {
                window.location.href = 'login.php';
                return;
            }
            
            document.getElementById('profile-content').innerHTML = `
                <div class="card" style="max-width: 400px; margin: 0 auto;">
                    <img src="${user.avatar_url}" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 20px;">
                    <h3>${user.username}</h3>
                    <p>${user.email}</p>
                    <p>Membro dal: ${new Date(user.created_at).toLocaleDateString()}</p>
                    <button class="btn" onclick="logout()">Logout</button>
                </div>
            `;
        });
    </script>
</body>
</html>
