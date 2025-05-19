document.addEventListener('keydown', function(e) {
    if(e.key === "Enter"){
        e.preventDefault();
        const active = document.activeElement;
        if(active.id === 'keyboard-message'){
            sendMessage();
        }
    }
});

async function sendMessage(){
    try{
    const isLogged = await isLoggedIn();
    if(!isLogged.isLogged){
        loadLogin();
    }
    
    let message = document.getElementById("keyboard-message");
    if(message != ""){
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
    
    }
    }catch(e){
        
    }
    
    // openChat(chat_id);
}