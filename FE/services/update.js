async function checkForMessages(loggedIn){
    const responce = await isLoggedIn();
    console.log(responce);

    if(!responce?.isLogged){
        console.log(responce?.isLogged);
        return "ciao";
    }

    console.log("no");

    let checkresponce = fetch(`${API_BASE_URL}/checkformessages`)
    .then(res => res.json());
    console.log(checkresponce);
}

