const routes = [
    { path: '/', page: 'home', handler: loadHome },
    // { path: '/about', page: 'about', handler: loadAbout },
    // { path: '/contact', page: 'contact', handler: loadContact },
];

document.addEventListener('DOMContentLoaded', function () {
    console.log(window.location.pathname);
    
    loadHome();
    loadChats();
});


async function loadHome() {
    fetch('pages/home/home.html')
    .then(res  => res.text())
    .then(html  => {
        document.getElementById("app").innerHTML = html
    })
    .catch(err => {
        console.error("Errore nel caricamento della Home:", err);
    });

}