document.addEventListener('keydown', function(e) {
    if(e.key === "Enter"){
        e.preventDefault();
        const active = document.activeElement;
        let app = document.getElementById('app')

        let loginelement = document.getElementById('login');
        let registerelement = document.getElementById('register');

        if(app.contains(loginelement))
        {
            login()
        }else if(app.contains(registerelement)){
            register()
        }

        
    }
});

async function loadLogin() {
    try {
        const res = await fetch('./pages/login/login.html');
        const html = await res.text();
        document.getElementById("app").innerHTML = html;

        
        const registerLink = document.getElementById("register-link");
        if (registerLink) {
            registerLink.addEventListener('click', function(e){
                
                e.stopPropagation();
                loadRegister();
            },true);
        }
    } catch (err) {
        console.error("Errore nel caricamento della Home:", err);
    }
}
