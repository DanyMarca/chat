document.addEventListener('DOMContentLoaded', async function (e) {
    e.preventDefault();
});

function login(){
    console.log("login");
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    
    fetch("http://localhost/chat/BE/api/login", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: "include",  // Assicurati di usare i cookies se il backend usa sessioni
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(res => res.json())
    .then(responce => {
        if (responce.status === "success") {
            alert("Login avvenuto con successo");
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
}

function logout() {
    localStorage.removeItem('loggedIn');
}

function isLoggedIn() {
    return fetch('http://localhost/chat/BE/api/sessioncheck', {
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
        return false;
    });
}


