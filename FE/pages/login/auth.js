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

function register() {
    // console.log("click");
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirm_password = document.getElementById('confirm-password').value;

    // console.log('password: ', password == confirm_password);
    if(!(password == confirm_password)){
        alert('❌ password non combaciano');
        password.cla
        return;
    }
    // console.log(confirm_password);
}