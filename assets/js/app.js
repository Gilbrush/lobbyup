document.addEventListener('DOMContentLoaded', () => {
    console.log('LobbyUp app loaded');

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

        // Aggiungi token se presente
        const token = localStorage.getItem('token');
        if (token) {
            options.headers['Authorization'] = `Bearer ${token}`;
        }

        try {
            const response = await fetch(`/api/${endpoint}`, options);
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, message: 'Errore di connessione' };
        }
    }

    // Esempio gestione form login
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = loginForm.email.value;
            const password = loginForm.password.value;

            const res = await apiCall('auth/login.php', 'POST', { email, password });
            
            if (res.success) {
                localStorage.setItem('token', res.data.token);
                localStorage.setItem('user', JSON.stringify(res.data.user));
                window.location.href = 'index.php';
            } else {
                alert(res.message);
            }
        });
    }

    // Carica sessioni in evidenza (se siamo in home)
    const sessionsContainer = document.getElementById('featured-sessions');
    if (sessionsContainer) {
        // Qui potremmo fare una chiamata reale all'API
        // apiCall('sessions/search.php').then(data => ... render ...)
    }
});
