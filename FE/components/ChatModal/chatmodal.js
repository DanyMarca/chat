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
    }, 200);
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
    let chat = await document.getElementById("create-chat-input");

    if(chat.value < 4){
        let debug = await document.getElementById("output-create-chat");
        debug.innerText = "4 letters needed"
        return null;
    }
    else{
    let debug = await document.getElementById("output-create-chat");
    debug.innerText = "creazione in corso..."
    console.log(chat.value);
    }

    fetch(`${API_BASE_URL}/chat/create`,{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: "include",
        body: JSON.stringify({
            name: chat.value,
        })})


}

function joinChat(){

}