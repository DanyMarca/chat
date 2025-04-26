// document.addEventListener('DOMContentLoaded', function () {
//     loadChats()
// });



async function loadChats() {
    const loggedIn = await isLoggedIn()
    Promise.all([
        fetch(`${API_BASE_URL}/Users/${loggedIn.user_id}`,).then(res => res.json()),
        fetch('./components/sidebar-chat/sidebar-chat.html').then(res => res.text()),
    ])
        .then(([responce, HTMLTemplate]) => {
                
            const chats = responce.data?.chats || [];
            renderChatsFromTemplate(chats, HTMLTemplate);
        })
        .catch(err => {
            console.error('Errore:', err);
        });
}

function renderChatsFromTemplate(chats, template) {
    const container = document.getElementById('sidebar-content-chats'); // Div dove aggiungi le chat
    // container.innerHTML = ''; // Pulisce prima

    chats.forEach(chat => {
        // Crea un DOM temporaneo
        const temp = document.createElement('div');
        temp.innerHTML = template;
        const chatElement = temp.firstElementChild;

        // Riempie i dati
        chatElement.setAttribute('chat-id', chat.id);
        chatElement.querySelector('.chat-name').textContent = chat.name;
        chatElement.querySelector('.status-text').textContent = chat.status ?? 'unknown';
        chatElement.querySelector('.status-color').style.backgroundColor = chat.status === 'online' ? 'green' : 'gray';
        chatElement.querySelector('.chat-image').style.backgroundImage = `url(${chat.image_url || 'images/default.jpg'})`;

        chatElement.addEventListener('click', () =>{
            const chatID = chatElement.getAttribute('chat-id');
            openChat(chatID);
        })

        container.appendChild(chatElement);
    });
}
