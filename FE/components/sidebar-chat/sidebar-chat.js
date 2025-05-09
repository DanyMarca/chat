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
        
        const temp = document.createElement('div');
        temp.innerHTML = template;
        const chatElement = temp.firstElementChild;

        // Riempie i dati
        chatElement.setAttribute('chat-id', chat.id);
        chatElement.querySelector('.chat-name').textContent = chat.name;
        chatElement.querySelector('.status-text').textContent = chat.status ?? 'unknown';
        chatElement.querySelector('.status-color').style.backgroundColor = chat.status === 'online' ? 'green' : 'gray';
        chatElement.querySelector('.chat-image').style.backgroundImage = `url(${chat.image_url || 'assets/default.jpg'})`;

        chatElement.addEventListener('click', () => {
            isLoggedIn().then(obj => {
                if (obj.isLogged) {
                    const chatID = chatElement.getAttribute('chat-id');
                    openChat(chatID);
                    if (window.innerWidth <= 768) {
                        responsiveChat();
                    }
                } else {
                    loadLogin();
                }

                
            });
        });
        

        container.appendChild(chatElement);
    });
}

function responsiveChat(){
    document.getElementById('sidebar').classList.remove('active');
    document.getElementById('main').classList.add('active');
}

function backToSidebar() {
    document.getElementById('main').classList.remove('active');
    document.getElementById('sidebar').classList.add('active');
}