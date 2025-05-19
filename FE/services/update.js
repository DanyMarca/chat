async function checkForMessages(loggedIn){
    const responce = await isLoggedIn();

    if(!responce?.isLogged){
        return "ciao";
    }


    let checkresponce = fetch(`${API_BASE_URL}/checkformessages`)
    .then(res => res.json());
}

