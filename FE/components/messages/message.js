async function makeMessage(info, user_id) {
    const template = await fetch('./components/messages/message.html')
    .then(res => res.text());
    const temp = document.createElement('div');
    temp.innerHTML = template;
    const message = temp.firstElementChild;

    message.setAttribute('message-id',info.id);

    message.querySelector('.message-time').textContent=info.created_at;
    
    message.querySelector('.message-content').textContent=info.content;
    
    message.querySelector('.message-owner').textContent=info.user_id

    if (info.user_id == user_id) {
        console.log("ciao");
        message.classList.add('sending');
    }
    else {
        message.classList.add('coming');
    }
    return message;
}
// "id": 22,
// "created_at": "2025-04-24 14:29:56",
// "user_id": 8,
// "chat_id": 1,
// "content": "Messaggio_997"