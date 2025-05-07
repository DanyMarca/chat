async function loadHome() {
    try {
        const res = await fetch('./pages/home/home.html');
        const html = await res.text();

        const app = document.getElementById("app");
        app.innerHTML = html;

        // Ora che l'HTML è stato iniettato, puoi aggiungere l'event listener
        Logout_listener();

    } catch (err) {
        console.error("Errore nel caricamento della Home:", err);
    }
}

function Logout_listener() {
    
    const logout = document.getElementById("logout-link");
    if (!logout) return; // evita errori se non trovato

    logout.addEventListener('click', async (event) => {
        event.preventDefault();
        try {
            
            const res = await fetch(`${API_BASE_URL}/logout`, {
                method: 'POST',
                credentials: 'include'
            });
            if (res.ok) {
                loadIndex();
            } else {
                console.error("Logout fallito");
            }
        } catch (err) {
            console.error("Errore durante il logout:", err);
        }
    });
}

function create_chat(){
    openModal();
}

