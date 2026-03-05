<?php
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LobbyUp</title>
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
                <li><a href="login.php" class="btn">Login</a></li>
                <li><a href="register.php" class="btn">Registrati</a></li>
            </ul>
        </nav>
    </header>

    <div class="container auth-container">
        <h2>Accedi al tuo account</h2>
        <form id="login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="tuo@email.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="********">
            </div>
            <button type="submit" class="btn full-width">Login</button>
            <p style="margin-top: 15px; text-align: center;">Non hai un account? <a href="register.php" style="color: var(--primary-color);">Registrati</a></p>
        </form>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>
