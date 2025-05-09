// document.addEventListener("click",function(){
//     closeChat();
// })

async function openChat(chatID) {
    const main = document.getElementById('main');
    main.setAttribute('chat_id', chatID);
    main.innerHTML = "";

    const [response, mainTemplate, keyboardTemplate] = await loadChatData(chatID);

    const mainChat = await buildMainChat(mainTemplate);

    insertKeyboard(mainChat, keyboardTemplate);
    fillHeader(mainChat, response.data.chat);

    main.appendChild(mainChat); // 👈 PRIMA questo

    await loadMessages(mainChat, response.data.messages, response.data.chat?.user_id);
}




// Funzione per caricare dati da API e template HTML
async function loadChatData(chatID) {
    return Promise.all([
        fetch(`${API_BASE_URL}/chat/${chatID}`).then(res => res.json()),
        fetch('./pages/main/main.html').then(res => res.text()),
        fetch('./components/keyboard/keyboard.html').then(res => res.text()),
    ]);
}

// Funzione per creare l'elemento principale della chat
async function buildMainChat(templateHTML) {
    const temp = document.createElement('div');
    temp.innerHTML = templateHTML;
    return temp.firstElementChild;
}

// Funzione per inserire la tastiera
async function insertKeyboard(mainChat, keyboardHTML) {
    const tempKeyboard = document.createElement('div');
    tempKeyboard.innerHTML = keyboardHTML;
    const keyboardElement = tempKeyboard.firstElementChild;
    mainChat.appendChild(keyboardElement);
    
}

// Funzione per riempire l'intestazione della chat (nome e immagine)
function fillHeader(mainChat, chatData) {
    mainChat.querySelector('.main-header-chat-name').textContent = chatData?.name || "Chat senza nome";
    mainChat.querySelector('.main-header-profile-image').style.backgroundImage = `url(${chatData?.image_url || 'assets/default.jpg'})`;
    
}

async function loadLastMeesage(chat_id) {
    const response = await fetch(`${API_BASE_URL}/message/last/${chat_id}`);
    const lastMessage = await response.json();

    // console.log(lastMessage);
    const chatMessages = document.querySelector('.main-chat');
    const tempMessage = await makeMessage(lastMessage, lastMessage['user_id']);
    
    chatMessages.appendChild(tempMessage);
    // console.log(tempMessage)

    chatMessages.scrollTo({
        top: chatMessages.scrollHeight,
        behavior: 'smooth'
    });
    
}

// Funzione per caricare i messaggi nella chat
async function loadMessages(mainChat, messages, userId) {
    const chatMessages = mainChat.querySelector('.main-chat');

    for (const message of messages) {
        const tempMessage = await makeMessage(message, userId);
        chatMessages.appendChild(tempMessage);
    }

    // Scrolla in fondo SOLO alla fine
    chatMessages.scrollTo({
        top: chatMessages.scrollHeight,
        behavior: 'auto' // oppure 'smooth' se preferisci animazione
    });
}


async function closeChat() {
    const main = document.getElementById('main');
    main.innerHTML="";
}