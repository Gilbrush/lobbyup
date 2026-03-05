document.addEventListener('DOMContentLoaded', () => {
    console.log('LobbyUp app loaded');
    updateAuthUI();
});

// Funzione helper per fetch API
async function apiCall(endpoint, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        }
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    const token = localStorage.getItem('token');
    if (token) {
        options.headers['Authorization'] = `Bearer ${token}`;
    }

    try {
        const response = await fetch(`api/${endpoint}`, options);
        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        return { success: false, message: 'Errore di connessione' };
    }
}

// User Menu Toggle
function toggleUserMenu() {
    const dropdown = document.querySelector('.dropdown-content');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.user-menu') && !event.target.matches('.user-menu *')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
    // Close modal
    const modal = document.getElementById('session-modal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Gestione UI Autenticazione
function updateAuthUI() {
    const authLinks = document.getElementById('auth-links');
    const user = JSON.parse(localStorage.getItem('user'));

    if (authLinks) {
        if (user) {
            authLinks.innerHTML = `
                <div class="user-menu" onclick="toggleUserMenu()">
                    <img src="${user.avatar_url || 'assets/images/default-avatar.png'}" alt="Avatar" class="user-avatar">
                    <span>${user.username}</span>
                    <div class="dropdown-content">
                        <a href="profile.php">👤 Profilo</a>
                        <a href="settings.php">⚙️ Impostazioni</a>
                        <a href="#" onclick="logout()">🚪 Logout</a>
                    </div>
                </div>
            `;
        } else {
            authLinks.innerHTML = `
                <a href="login.php" class="btn" style="margin-right: 10px;">Login</a>
                <a href="register.php" class="btn">Registrati</a>
            `;
        }
    }
}

function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = 'index.php';
}

// Caricamento Sessioni Homepage
async function loadFeaturedSessions() {
    const container = document.getElementById('featured-sessions');
    if (!container) return;

    const res = await apiCall('sessions/search.php');
    
    if (res.success && res.data.length > 0) {
        container.innerHTML = res.data.map(session => createSessionCard(session)).join('');
    } else {
        container.innerHTML = '<p>Nessuna sessione trovata al momento.</p>';
    }
}

// Template Card Sessione
function createSessionCard(session) {
    // Fallback images
    const coverImage = session.cover_image || 'assets/images/default-game.jpg';
    const platformLogo = session.platform_logo || 'assets/images/default-platform.png';

    // Gestione date
    const date = new Date(session.session_date + 'T' + session.start_time);
    const dateStr = date.toLocaleDateString('it-IT', { weekday: 'short', day: 'numeric', month: 'short' });
    const timeStr = date.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });

    return `
        <div class="card" style="background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.9)), url('${coverImage}'); background-size: cover; background-position: center;">
            <div class="card-header">
                <img src="${platformLogo}" alt="${session.platform_name}" class="platform-icon" style="width: 24px; height: 24px; object-fit: contain; background: white; border-radius: 50%; padding: 2px;">
                <span class="badge">${session.platform_name}</span>
            </div>
            <div class="card-body">
                <h3 onclick="openGameDetails(${session.game_id})" style="cursor: pointer; text-decoration: underline;">${session.game_name}</h3>
                <p class="desc">${session.description || 'Nessuna descrizione.'}</p>
                <div class="meta">
                    <span class="date">📅 ${dateStr} - ${timeStr}</span>
                    <span class="players">👥 ${session.current_players}/${session.max_players}</span>
                </div>
                <div class="host">
                    <small onclick="showHostInfo('${session.creator_name}')" style="cursor: pointer; text-decoration: underline;">Host: ${session.creator_name}</small>
                </div>
            </div>
            <div class="card-footer">
                <button class="join-btn" onclick='openSessionModal(${JSON.stringify(session)})'>UNISCITI</button>
            </div>
        </div>
    `;
}

// Open Game Details Modal
async function openGameDetails(gameId) {
    const modal = document.getElementById('session-modal'); // Riutilizziamo lo stesso modal per semplicità
    const body = document.getElementById('modal-body');
    
    // Mostra loading
    modal.style.display = "block";
    body.innerHTML = "<p>Caricamento dettagli gioco...</p>";
    document.getElementById('modal-title').innerText = "Dettagli Gioco";
    document.getElementById('modal-join-btn').style.display = 'none';

    // Mock API call (in produzione chiameremmo /api/games/details.php)
    // Qui simuliamo i dati recuperando info dalla sessione o facendo una chiamata search
    const res = await apiCall(`games/search.php?query=&id=${gameId}`); // Assumiamo che search supporti id o filtriamo
    
    // Per ora usiamo dati statici simulati basati su ID per demo
    body.innerHTML = `
        <div class="game-details">
            <p>Dettagli completi del gioco #${gameId} in arrivo.</p>
            <p>Qui verranno mostrati: Trailer, Screenshot, Descrizione lunga e altre sessioni attive.</p>
        </div>
    `;
    
    // Close modal logic
    document.querySelector('.close-modal').onclick = () => {
        modal.style.display = "none";
        document.getElementById('modal-join-btn').style.display = 'inline-block'; // Reset
    }
}

// Modal Logic
function openSessionModal(session) {
    const modal = document.getElementById('session-modal');
    const title = document.getElementById('modal-title');
    const body = document.getElementById('modal-body');
    const joinBtn = document.getElementById('modal-join-btn');

    // Fallback images
    const coverImage = session.cover_image || 'assets/images/default-game.jpg';

    // Pulisci titolo modal base
    title.innerText = "";
    
    // Header personalizzato con immagine gioco
    body.innerHTML = `
        <div class="game-modal-header" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.9)), url('${coverImage}');">
            <div class="game-title-overlay">
                <h2 style="margin:0; font-size: 1.8rem;">${session.game_name}</h2>
                <div style="margin-top:5px;"><span class="badge">${session.platform_name}</span></div>
            </div>
        </div>
        <div style="padding: 10px;">
            <p><strong>Host:</strong> ${session.creator_name}</p>
            <p><strong>Descrizione:</strong> ${session.description}</p>
            <p><strong>Data:</strong> ${session.session_date} alle ${session.start_time}</p>
            <p><strong>Giocatori:</strong> ${session.current_players}/${session.max_players}</p>
        </div>
    `;
    
    joinBtn.style.display = 'block';
    joinBtn.innerText = "CONFERMA PARTECIPAZIONE";
    joinBtn.onclick = () => alert('Funzionalità Unisciti in arrivo! (Richiede Auth Backend)');
    
    modal.style.display = "block";

    // Close modal logic
    document.querySelector('.close-modal').onclick = () => {
        modal.style.display = "none";
    }
}

// Gestione Login Form
const loginForm = document.getElementById('login-form');
if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);
        const data = Object.fromEntries(formData.entries());

        const res = await apiCall('auth/login.php', 'POST', data);
        
        if (res.success) {
            localStorage.setItem('token', res.data.token);
            localStorage.setItem('user', JSON.stringify(res.data.user));
            window.location.href = 'index.php';
        } else {
            alert(res.message);
        }
    });
}

// Gestione Register Form
const registerForm = document.getElementById('register-form');
if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(registerForm);
        const data = Object.fromEntries(formData.entries());

        if (data.password !== data.confirm_password) {
            alert('Le password non coincidono');
            return;
        }

        const res = await apiCall('auth/register.php', 'POST', data);
        
        if (res.success) {
            alert('Registrazione completata! Ora puoi effettuare il login.');
            window.location.href = 'login.php';
        } else {
            alert(res.message);
        }
    });
}
