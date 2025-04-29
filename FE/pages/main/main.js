async function openChat(chatID) {
    const main = document.getElementById('main');
    main.innerHTML = "";

    const [response, mainTemplate, keyboardTemplate] = await loadChatData(chatID);

    const mainChat = buildMainChat(mainTemplate);
    insertKeyboard(mainChat, keyboardTemplate);
    fillHeader(mainChat, response.data.chat);
    await loadMessages(mainChat, response.data.messages, response.data.chat?.user_id);

    main.appendChild(mainChat);
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
function buildMainChat(templateHTML) {
    const temp = document.createElement('div');
    temp.innerHTML = templateHTML;
    return temp.firstElementChild;
}

// Funzione per inserire la tastiera
function insertKeyboard(mainChat, keyboardHTML) {
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

// Funzione per caricare i messaggi nella chat
async function loadMessages(mainChat, messages, userId) {
    const chatMessages = mainChat.querySelector('.main-chat');
    for (const message of messages) {
        const tempMessage = await makeMessage(message, userId);
        chatMessages.appendChild(tempMessage);
    }
}
