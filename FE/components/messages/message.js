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
        message.classList.add('sending');
    }
    else {
        message.classList.add('coming');
    }
    return message;
}
