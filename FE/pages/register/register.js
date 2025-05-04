async function loadRegister() {
    try {
        const res = await fetch('./pages/register/register.html');
        const html = await res.text();
        document.getElementById("app").innerHTML = html;

        const loginLink = document.getElementById("login-link");
        if (loginLink) {
            loginLink.addEventListener('click', function(){
                loadLogin(); // Torna al login
            });
        }
    } catch (err) {
        console.error("Errore nel caricamento della Registrazione:", err);
    }
}
