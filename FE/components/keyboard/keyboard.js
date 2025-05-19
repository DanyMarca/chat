document.addEventListener('keydown', function(e) {
    if(e.key === "Enter"){
        e.preventDefault();
        sendMessage();
    }
});

async function sendMessage(){
    const isLogged = await isLoggedIn();
    if(!isLogged.isLogged){
        console.log(isLogged);
        loadLogin();
    }
    let message = document.getElementById("keyboard-message");
    let chat_id = document.getElementById("main").getAttribute('chat_id');
    
    if(message.value != "") {
        
        const res = await fetch(`${API_BASE_URL}/sendMessage`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-type':'application/json'
            },
            body: JSON.stringify({
                message: message.value,
                chat_id: chat_id
            })

        });
        message.value = "";
        loadLastMeesage(chat_id);
    }
    
    // openChat(chat_id);
}