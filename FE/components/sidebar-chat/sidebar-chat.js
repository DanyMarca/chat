document.addEventListener('DOMContentLoaded', function ()
{
    loadChats()
    
});

function loadChats() {
    fetch('components/sidebar-chat/sidebar-chat.html')
    .then(res =>{
        
        if (!res.ok){
            throw new Error("file html non trovato")
            }
        return res.text()
    })
    .then(data => {
        const container = document.getElementById('sidebar-content-chats');
        container.innerHTML = data;
    })
    .catch(error =>{
        console.error('Errore nel caricare il file:', error);
    })
}