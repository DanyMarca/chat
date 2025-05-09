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


async function validateUsername(username, field) {
    if (username.length < 3) {
        field.style.borderColor = "red";
        return "❌ Username troppo corto (minimo 3 caratteri)";
    }
    field.style.borderColor = "";
    return null;
}

async function validateEmail(email, field) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        field.style.borderColor = "red";
        return "❌ Inserisci un'email valida";
    }
    field.style.borderColor = "";
    return null;
}

async function validatePassword(password, field) {
    if (password.length < 6) {
        field.style.borderColor = "red";
        return "❌ La password deve avere almeno 6 caratteri";
    }
    field.style.borderColor = "";
    return null;
}

async function validateConfirmPassword(password, confirmPassword, field1, field2) {
    if (password !== confirmPassword) {
        field1.style.borderColor = "red";
        field2.style.borderColor = "red";
        return "❌ Le password non combaciano";
    }
    field1.style.borderColor = "";
    field2.style.borderColor = "";
    return null;
}


