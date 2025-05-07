async function openModal(){
    let modal = await document.querySelector('.modal-wrapper')
    modal.style.display = "flex";
}

async function closeModal(){
    let modal = await document.querySelector('.modal-wrapper')
    modal.style.display = "none";
}

async function clickOutOfModal() {
    document.querySelector('.modal-wrapper').addEventListener("click", function (event) {
    const modalContent = document.getElementById("create-chat-modal-card");
    if (!modalContent.contains(event.target)) {
            closeModal();
        }
    });
}

function loadModal(){
    
}


