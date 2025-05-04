async function loadLogin() {
    try {
        const res = await fetch('./pages/login/login.html');
        const html = await res.text();
        document.getElementById("app").innerHTML = html;

        // Adesso puoi aggiungere il listener
        const registerLink = document.getElementById("register-link");
        if (registerLink) {
            registerLink.addEventListener('click', function(){
                loadRegister();
            });
        }
    } catch (err) {
        console.error("Errore nel caricamento della Home:", err);
    }
}
