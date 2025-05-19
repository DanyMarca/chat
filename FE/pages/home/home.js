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
    loseFocus();
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
    loseFocus();
    loadModal();
}

async function loseFocus(){
    let el = document.getElementById('sidebar-user-settings');
    
    setTimeout(() => {
        el.blur();
    }, 20);
}

async function searchBarListener(){
    

    const search = document.querySelector('.sidebar-search');
    
    search.addEventListener('input', () => {
        let chats = document.querySelectorAll('.chat');

        const query = search.value.toLowerCase();

        chats.forEach(chat => {
            const text = chat.querySelector('.chat-name')?.textContent.toLowerCase() || '';
            chat.style.display = text.includes(query) ? "flex" : "none";
        });
    })
}