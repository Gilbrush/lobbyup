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

// Gestione UI Autenticazione
function updateAuthUI() {
    const authLinks = document.getElementById('auth-links');
    const user = JSON.parse(localStorage.getItem('user'));

    if (authLinks) {
        if (user) {
            authLinks.innerHTML = `
                <span style="margin-right: 15px;">Ciao, ${user.username}</span>
                <button class="btn" onclick="logout()">Logout</button>
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
    const platformLogo = session.platform_logo || 'assets/images/default-platform.png'; // Ora i loghi sono nel DB, ma il JOIN deve prenderli

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
                <h3>${session.game_name}</h3>
                <p class="desc">${session.description || 'Nessuna descrizione.'}</p>
                <div class="meta">
                    <span class="date">📅 ${dateStr} - ${timeStr}</span>
                    <span class="players">👥 ${session.current_players}/${session.max_players}</span>
                </div>
                <div class="host">
                    <small>Host: ${session.creator_name}</small>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn full-width" onclick="joinSession(${session.id})">Unisciti</button>
            </div>
        </div>
    `;
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
