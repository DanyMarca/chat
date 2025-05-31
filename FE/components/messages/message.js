async function makeMessage(info, user_id) {
    const template = await fetch('./components/messages/message.html')
    .then(res => res.text());
    const temp = document.createElement('div');
    temp.innerHTML = template;
    const message = temp.firstElementChild;

    message.setAttribute('message-id',info.id);

    // message.querySelector('.message-time').textContent=info.created_at;
    message.querySelector('.message-time').textContent=formatDate(info.created_at);
    
    message.querySelector('.message-content').textContent=info.content;
    
    message.querySelector('.message-owner').textContent=info.user_name;

    // console.log("from: " , info.user_id, "to" , user_id)

    if (info.user_id == user_id) {
        message.classList.add('sending');
    }
    else {
        message.classList.add('coming');
    }
    return message;
}

function formatDate(ts) {
    const d = new Date(ts);
    return `${String(d.getMonth() + 1).padStart(2, '0')}/` +
            `${String(d.getDate()).padStart(2, '0')} ` +
            `${String(d.getHours()).padStart(2, '0')}:` +
            `${String(d.getMinutes()).padStart(2, '0')}`;
}