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
            <input type="text" id="search-input" placeholder="Filtra per gioco o piattaforma...">
            <button class="btn" id="search-btn">Cerca</button>
        </div>

        <div class="card-grid" id="search-results">
            <!-- Risultati caricati dinamicamente -->
            <p style="color: #888;">Caricamento sessioni...</p>
        </div>
    </div>
    
    <!-- Modal Dettaglio Sessione -->
    <div id="session-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modal-title">Dettagli Sessione</h2>
            <div id="modal-body">
                <!-- Contenuto dinamico -->
            </div>
            <div class="modal-footer" style="margin-top: 20px; text-align: right;">
                <button class="btn" id="modal-join-btn">Conferma Partecipazione</button>
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('q');
            
            // Gestione Search Page Logic
            const searchInput = document.getElementById('search-input');
            const searchBtn = document.getElementById('search-btn');
            const container = document.getElementById('search-results');
            
            function performSearch(q) {
                container.innerHTML = '<p>Ricerca in corso...</p>';
                
                let endpoint = 'sessions/search.php';
                if (q) endpoint += `?q=${encodeURIComponent(q)}`;
                
                apiCall(endpoint).then(res => {
                    if (res.success && res.data.length > 0) {
                        container.innerHTML = res.data.map(session => createSessionCard(session)).join('');
                    } else {
                        container.innerHTML = '<p>Nessuna sessione trovata per la tua ricerca.</p>';
                    }
                });
            }

            if (query) {
                searchInput.value = query;
                performSearch(query);
            } else {
                performSearch(''); // Carica tutto se non c'è query
            }
            
            function handleSearch() {
                const newQuery = searchInput.value;
                const newUrl = new URL(window.location);
                if (newQuery) {
                    newUrl.searchParams.set('q', newQuery);
                } else {
                    newUrl.searchParams.delete('q');
                }
                window.history.pushState({}, '', newUrl);
                performSearch(newQuery);
            }

            searchBtn.addEventListener('click', handleSearch);
            
            // Enter key support
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') handleSearch();
            });
        });
    </script>
</body>
</html>
