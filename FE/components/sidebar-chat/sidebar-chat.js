document.addEventListener('DOMContentLoaded', function () {
    loadChats()
});



function loadChats() {
    Promise.all([
        fetch('http://localhost/chat/BE/Api/Users/2').then(res => res.json()),
        fetch('components/sidebar-chat/sidebar-chat.html').then(res => res.text()),
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
        chatElement.querySelector('.chat-name').textContent = chat.name;
        chatElement.querySelector('.status-text').textContent = chat.status;
        chatElement.querySelector('.status-color').style.backgroundColor = chat.status === 'online' ? 'green' : 'gray';
        chatElement.querySelector('.chat-image').style.backgroundImage = `url(${chat.image_url || 'images/default.jpg'})`;

        container.appendChild(chatElement);
    });
}
