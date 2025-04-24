function login() {
    localStorage.setItem('loggedIn', 'true');
}

function logout() {
    localStorage.removeItem('loggedIn');
}

function isLoggedIn() {
    return localStorage.getItem('loggedIn') === 'true';
}
