async function openModal(){
    let modal = await document.querySelector('.modal-wrapper')
    modal.style.animation = 'fadeInUp 0.3s ease-out forwards'
    modal.style.display = "flex";

}

async function closeModal(){
    let modal = await document.querySelector('.modal-wrapper')
    modal.style.animation = 'fadeOutDown 0.3s ease-out forwards'
    setTimeout(() => {
        modal.style.display = "none";
        modal.remove();
    }, 200)
    
    
}

async function clickOutOfModal() {
    document.querySelector('.modal-wrapper').addEventListener("click", function (event) {
        const modalContent = document.getElementById("chat-modal-card");
        if (!modalContent.contains(event.target)) {

            closeModal();
        }
    });
}


function loadModal(){
    let modal = document.querySelector('.modal-wrapper')

    if (modal == null) {

        let positionhtml = document.getElementById('sidebar-content');

        fetch('./components/chatmodal/chatmodal.html')
            .then(res => res.text())
            .then(html => {
                let wrapper = document.createElement('div');
                wrapper.innerHTML = html;
                // Puoi fare anche: wrapper.firstElementChild se vuoi appendere solo il primo nodo
                positionhtml.appendChild(wrapper);
                openModal();
            })
            .catch(err => console.error("Errore nel caricamento del modal:", err));
    }else{
        openModal();
    }
}




async function createChat(){ //http://localhost/chat/BE/Api/chat/create
    let chat_name = await document.getElementById("create-chat-input");
    let debug = await document.getElementById("output-create-chat");

    if(chat_name.value.length < 4){
        debug.innerText = "4 letters needed"
        return null;

    }else{
        debug.innerText = "creazione in corso..."

    }

    fetch(`${API_BASE_URL}/chat/create`,{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: "include",
        body: JSON.stringify({
            name: chat_name.value,
        })
    })
    .then(res => {
        if(res.ok){
            
            closeModal();
            loadChats();
        }
    });
}

async function joinChat(){
    let chat_code = await document.getElementById("join-chat-input");
    let debug = await document.getElementById("output-join-chat");


    if(chat_code.value.length != 16){
        debug.innerText = "16 characters needed"
        return null;

    }else{
        debug.innerText = "join in corso..."

        fetch(`${API_BASE_URL}/chat/join`,{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: "include",
            body: JSON.stringify({
                chat_code: chat_code.value,
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.ok){
                closeModal();
                loadChats();
            }else{
                chat_name = (res.chat_name.length > 10 ? res.chat_name.slice(0,7) + '...' : res.chat_name);
                debug.innerText = res.message + "\n" +chat_name;
            }
        });
    }
}
