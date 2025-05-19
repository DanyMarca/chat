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
    // console.log('index: ', isLogged.isLogged);
    
    if(isLogged.isLogged){
        
        loadHome();
        loadChats();
        checkForMessages();
        // console.log("carica")
    }
    else{
        loadLogin();
    }
}




