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
        <div class="logo">LobbyUp</div>
        <nav>
            <ul>
                <li><a href="search.php">Cerca Sessioni</a></li>
                <li><a href="servers.php">Server</a></li>
                <li><a href="login.php" class="btn">Login</a></li>
                <li><a href="register.php" class="btn">Registrati</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero container">
        <h1>Trova il tuo party. <br> Gioca meglio.</h1>
        <p>Unisciti a migliaia di giocatori, crea la tua sessione e domina il gioco.</p>
        
        <div class="search-bar">
            <input type="text" placeholder="Cerca gioco (es. Fortnite, Warzone)...">
            <button class="btn">Cerca</button>
        </div>
    </section>

    <section class="container">
        <h2>Sessioni in Evidenza</h2>
        <div class="card-grid" id="featured-sessions">
            <!-- Sessioni caricate via JS -->
            <div class="card">
                <h3>Warzone Squad</h3>
                <p>Cerchiamo 2 player per ranked stasera.</p>
                <div class="meta">
                    <span>PS5</span>
                    <span>20:00</span>
                    <span>2/4 Posti</span>
                </div>
            </div>
            <div class="card">
                <h3>FIFA Pro Club</h3>
                <p>Provini aperti per ruolo ATT/COC.</p>
                <div class="meta">
                    <span>Xbox</span>
                    <span>21:30</span>
                    <span>1/11 Posti</span>
                </div>
            </div>
            <div class="card">
                <h3>Minecraft Vanilla</h3>
                <p>Nuovo server survival, cerchiamo builder.</p>
                <div class="meta">
                    <span>PC</span>
                    <span>Sempre</span>
                    <span>5/20 Posti</span>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 LobbyUp. Tutti i diritti riservati.</p>
    </footer>

    <script src="assets/js/app.js"></script>
    <script>
        // Registrazione Service Worker per PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('sw.js')
                    .then(reg => console.log('SW registrato:', reg))
                    .catch(err => console.log('SW errore:', err));
            });
        }
    </script>
</body>
</html>
