const routes = [
    { path: '/', page: 'home', handler: loadIndex },
    // { path: '/me', page: 'me', handler: loadAbout },
    // { path: '/contact', page: 'contact', handler: loadContact },
];

document.addEventListener('DOMContentLoaded', async function (e) {
    e.preventDefault();
    loadIndex()
});

async function loadIndex() {
    const isLogged = await isLoggedIn();
    
    
    if(isLogged.isLogged){
        
        loadHome();
        loadChats();
        checkForMessages();
        
    }
    else{
        loadLogin();
    }
}




