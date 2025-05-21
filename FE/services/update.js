async function updateLast_activity() {
    
    let response = fetch(`${API_BASE_URL}/auth/updatelast_activity`)
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

let pollingActive = true;
let pollingInProgress = false;

let baseDelay = 500;
let maxDelay = 20000;
let currentDelay = baseDelay;

async function checkForMessages() {
    pollingActive = true;

    while (pollingActive) {
        if (pollingInProgress || document.hidden) {
            await sleep(currentDelay);
            continue;
        }

        pollingInProgress = true;

        try {
            const response = await isLoggedIn();

            if (!response?.isLogged) {
                pollingActive = false;
                return loadIndex(); // utente disconnesso
            }

            const checkResponse = await fetch(`${API_BASE_URL}/checkformessages`);
            const data = await checkResponse.json();


            if (data.has_new_messages) {
                // Reset delay se arrivano nuovi messaggi
                currentDelay = baseDelay;
                let chat_id = document.getElementById("main").getAttribute('chat_id');
                loadChats();
                loadLastMeesage(chat_id);
                // updateLast_activity();
            } else {
                
                currentDelay = Math.min(currentDelay + 1000, maxDelay);
            }

        } catch (error) {
            console.error("Errore nel check dei messaggi:", error);
            currentDelay = Math.min(currentDelay + 3000, maxDelay);
        }

        pollingInProgress = false;
        await sleep(currentDelay);
    }
}

function stopPolling() {
    pollingActive = false;
}
