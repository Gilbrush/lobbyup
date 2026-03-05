<?php
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LobbyUp - Trova il tuo party</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>

    <header class="container">
        <div class="logo"><a href="index.php" style="color: inherit; text-decoration: none;">LobbyUp</a></div>
        <nav>
            <ul>
                <li><a href="search.php">Cerca Sessioni</a></li>
                <li><a href="servers.php">Server</a></li>
                <li id="auth-links">
                    <a href="login.php" class="btn">Login</a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="hero container">
        <h1>Trova il tuo party. <br> Gioca meglio.</h1>
        <p>Unisciti a migliaia di giocatori, crea la tua sessione e domina il gioco.</p>
        
        <form action="search.php" method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Cerca gioco (es. Fortnite, Warzone)..." required>
            <button type="submit" class="btn">Cerca</button>
        </form>
    </section>

    <section class="container">
        <h2>Sessioni in Evidenza</h2>
        <div class="card-grid" id="featured-sessions">
            <!-- Loading state -->
            <p>Caricamento sessioni...</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 LobbyUp. Tutti i diritti riservati.</p>
    </footer>

    <script src="assets/js/app.js"></script>
    <script>
        // Init Homepage logic
        document.addEventListener('DOMContentLoaded', () => {
            loadFeaturedSessions();
        });
    </script>
</body>
</html>
