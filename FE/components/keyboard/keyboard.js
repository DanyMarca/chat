async function sendMessage(){
    let message = document.getElementById("keyboard-message");
    console.log(message.value);
    message.value = "";
}

document.addEventListener('keydown', function(e) {
    if(e.key === "Enter"){
        e.preventDefault();
        sendMessage();
    }
});