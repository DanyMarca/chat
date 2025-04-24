const routes = [
    { path: '/', page: 'home', handler: loadHome },
    // { path: '/about', page: 'about', handler: loadAbout },
    // { path: '/contact', page: 'contact', handler: loadContact },
];

document.addEventListener('DOMContentLoaded', async function (e) {
    e.preventDefault();
    loadIndex()
});

async function loadIndex() {
    const isLogged = await isLoggedIn();
    console.log(isLogged);
    
    if(isLogged){
        
        loadHome();
        loadChats();
    }
    else{
        loadLogin();
    }
}


async function loadHome() {
    fetch('pages/home/home.html')
    .then(res  => res.text())
    .then(html  => {
        document.getElementById("app").innerHTML = ""
        document.getElementById("app").innerHTML = html
    })
    .catch(err => {
        console.error("Errore nel caricamento della Home:", err);
    });

}

async function loadLogin() {
    fetch('pages/login/login.html')
    .then(res => res.text())
    .then(html => {
        document.getElementById("app").innerHTML = ""
        document.getElementById("app").innerHTML=html
    })
    .catch(err => {
        console.error("Errore nel caricamento della Home:", err);
    });
}