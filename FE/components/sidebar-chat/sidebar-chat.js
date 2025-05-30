async function loadChats() {
    console.log("loadChat");
    const loggedIn = await isLoggedIn()

    try{
    let sidebar = await document.getElementById('sidebar-content-chats')
    sidebar.innerHTML = "";
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
    }catch{
        loadChats();
    }
}

function renderChatsFromTemplate(chats, template) {
    const container = document.getElementById('sidebar-content-chats'); // Div dove aggiungi le chat
    // container.innerHTML = ''; // Pulisce prima
    searchBarListener(chats);
    chats.forEach(chat => {
        
        const temp = document.createElement('div');
        temp.innerHTML = template;
        const chatElement = temp.firstElementChild;

        // Riempie i dati
        chatElement.setAttribute('chat-id', chat.id);
        chatElement.querySelector('.chat-name').textContent = chat.name;
        
        try{
        chatElement.querySelector('.last-message').textContent = chat.last_message 
        ? chat.last_message.content = chat.last_message.content.length > 27 
            ? chat.last_message.content.slice(0,27) +'...'
            : chat.last_message.content
        : '';
        }catch{
            
        }

        
        chatElement.querySelector('.chat-image').style.backgroundImage = `url(${chat.image_url || 'assets/default.jpg'})`;

        chatElement.addEventListener('click', (e) => {
            if (e.target.closest('.menu-icon')) return;
            isLoggedIn().then(obj => {
                if (obj.isLogged) {
                    const chatID = chatElement.getAttribute('chat-id');
                    if(document.getElementById('main').getAttribute('chat_id') != chatID ){
                        openChat(chatID);
                        }
                    if (window.innerWidth <= 768) {
                        responsiveChat();
                    }
                } else {
                    loadLogin();
                }

                
            });
        });
        let option_list = chatElement.querySelector('.chat-option-list-exit');
        if(option_list){
            option_list.addEventListener('click', (e) => { 
                e.stopPropagation();
                let chat = chatElement.getAttribute('chat-id');
                let chat_name = chatElement.textContent;
                exitFromChat(chat, chat_name);
            });  
        }
        

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

async function exitFromChat(chat_id){
    let res = await fetch(`${API_BASE_URL}/chat/delete`, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: "include",
        body: JSON.stringify({
            chat_id: chat_id,
        })
    });
    if(res.ok){
    
        alert("successfully exited");
        loadChats();
        closeChat();
    }
}