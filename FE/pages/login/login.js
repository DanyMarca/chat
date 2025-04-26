async function loadLogin() {
    fetch('./pages/login/login.html')
    .then(res => res.text())
    .then(html => {
        document.getElementById("app").innerHTML = ""
        document.getElementById("app").innerHTML=html
    })
    .catch(err => {
        console.error("Errore nel caricamento della Home:", err);
    });
}