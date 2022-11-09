const form = document.querySelector("#chat");
const messageInput = document.querySelector("#message");
const messages = document.querySelector("#messagesBox");
const userId = document.querySelector("#userId").value;
var socket = io('http://localhost:3000', {
    transports: ['websocket', 'polling', 'flashsocket'],
    withCredentials: true,
});

socket.emit("setSocketId", userId);

form.addEventListener("submit", function(event) {
    event.preventDefault();
    let message = messageInput.value;

    if (message) {
        socket.emit('message', {
            idReceiver: "2",
            message: message
        });
        console.log(message);
        messageInput.value = '';
    }
})

socket.on("newMessage", function(json) {
    console.log(json);
    var item = document.createElement('li');
    item.textContent = json.message;
    messages.appendChild(item);
    window.scrollTo(0, document.body.scrollHeight);
})

socket.on("disconnect", function(reason) {
    console.log(reason);
})