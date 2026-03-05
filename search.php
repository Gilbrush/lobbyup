<?php
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerca Sessioni - LobbyUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>

    <header class="container">
        <div class="logo"><a href="index.php" style="color: inherit; text-decoration: none;">LobbyUp</a></div>
        <nav>
            <ul>
                <li><a href="search.php" class="active">Cerca Sessioni</a></li>
                <li><a href="servers.php">Server</a></li>
                <li id="auth-links">
                    <!-- Popolato via JS -->
                    <a href="login.php" class="btn">Login</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Risultati Ricerca</h2>
        <div class="search-bar" style="margin-bottom: 30px; justify-content: flex-start;">
            <input type="text" id="search-input" placeholder="Filtra per gioco o piattaforma..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
            <button class="btn" id="search-btn">Cerca</button>
        </div>

        <div class="card-grid" id="search-results">
            <!-- Risultati caricati dinamicamente -->
            <p style="color: #888;">Caricamento sessioni...</p>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('q');
            if (query) {
                // Esegui ricerca
                console.log('Searching for:', query);
                // Qui chiameremmo l'API reale
            }
        });
    </script>
</body>
</html>
