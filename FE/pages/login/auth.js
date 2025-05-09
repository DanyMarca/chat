document.addEventListener('DOMContentLoaded', async function (e) {
    e.preventDefault();
});

function login(){
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    
    fetch(`${API_BASE_URL}/login`, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: "include",
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(res => res.json())
    .then(responce => {
        if (responce.status === "success") {
            // alert("Login avvenuto con successo");
            localStorage.setItem('user_id', responce.data.id);
            loadIndex();
        } else {
            alert('❌ Credenziali errate!');
        }
    })
    .catch(err => {
        console.error("Errore login:", err);
        alert('Errore di connessione.');
    });
    // console.log("login");
}

function logout() {
    localStorage.removeItem('loggedIn');
}

function isLoggedIn() {
    // console.log('API_BASE_URL/sessioncheck');
    return fetch(`${API_BASE_URL}/sessioncheck`, {
        credentials: 'include'
    })
    .then(res => res.json())
    .then(data => {
        return {
            'isLogged': data.loggedin,
            'user_id': data.data.user_id,
        };
    })
    .catch(err => {
        console.error("Errore nella fetch:", err);
        return {
            isLogged: false,
            user_id: null
        };
    });
}
async function register() {
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('confirm-password');

    const username = usernameField.value.trim();
    const email = emailField.value.trim();
    const password = passwordField.value;
    const confirmPassword = confirmField.value;

    const errors = [];

    const usernameError = await validateUsername(username, usernameField);
    if (usernameError) errors.push(usernameError);

    const emailError = await validateEmail(email, emailField);
    if (emailError) errors.push(emailError);

    const passwordError = await validatePassword(password, passwordField);
    if (passwordError) errors.push(passwordError);

    const confirmError = await validateConfirmPassword(password, confirmPassword, passwordField, confirmField);
    if (confirmError) errors.push(confirmError);

    if (errors.length > 0) {
        alert(errors.join('\n'));
    } else {
        alert("✅ Registrazione valida! Procedi pure.");
    }
}


