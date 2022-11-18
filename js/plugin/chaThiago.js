//TODO INTEGRATE SOCKET.IO, VISUALIZED MESSAGES, STYLE CSS, ADD PAGINATION

class chaThiago {
    constructor(elementId, contacts) {
        // data
        this.contacts = {};
        this.currContactGuid = null;

        // HTML elements
        this.fetchMessageLoading = this.createMessageLoading();
        this.chat = this.createChatSkeleton(elementId, contacts);
        this.conversationBox = chat.querySelector(`${elementId} .conversation-box`);
        this.chatSidebar = chat.querySelector(`${elementId} .sidebar`);

        // deal with sockets
        this.socket = this.setChatSocket();
    }

    setChatSocket() {
        let socket = io('http://localhost:3000', {
            transports: ['websocket', 'polling', 'flashsocket'],
            withCredentials: true,
        });
        // get userId somewhere
        socket.emit("setSocketId", 1);

        socket.on("disconnect", function(reason) {
            console.log(reason);
        });

        socket.on("newMessage", function(messageJson) {
            console.log(messageJson);
            
            appendNewMessages([ messageJson ]);
        });

        return socket;
    }

    createChatSkeleton(elementId, contacts) {
        const container = document.querySelector(elementId);
        const sidebar = this.createChatSidebar(contacts);
        const conversationBox = this.createConversationBox();

        container.appendChild(sidebar);
        container.appendChild(conversationBox);
        return container;
    }

    createConversationBox() {
        const conversationBox = document.createElement("div");
        conversationBox.classList.add("conversation-box");
        
        const headerBox = document.createElement("div");
        headerBox.classList.add("conversation-header");
        headerBox.innerHTML = "HEADER"

        const messagesDiv = document.createElement("div");
        messagesDiv.classList.add("messages");

        const textingBox = document.createElement("div");
        textingBox.classList.add("texting-box");
        const messagingForm = document.createElement("form");
        messagingForm.setAttribute("action", "javascript:void(0);");
        const messageInput = document.createElement("input");
        messageInput.classList.add("message-input");
        const sendMessageBtn = document.createElement("button");
        sendMessageBtn.innerHTML = "Send";

        messagingForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const input = event.currentTarget.querySelector("input");
            const message = input.value;
            
            if (message) {
                const timestamp = dayjs().format('YYYY-MM-DD HH:mm:ss');
                console.log("sending message");
                this.appendNewMessages([{ text: message, timestamp: timestamp, sent: true }]);
                await sendMessage(this.getCurrUserId(), message, timestamp);
                console.log("message sent");
                input.value = "";
            }
        })

        messagingForm.appendChild(messageInput);
        messagingForm.appendChild(sendMessageBtn);
        textingBox.appendChild(messagingForm);

        conversationBox.appendChild(headerBox);
        conversationBox.appendChild(messagesDiv);
        conversationBox.appendChild(textingBox);

        return conversationBox;
    };

    createChatSidebar(contacts) {
        const sidebar = document.createElement("div");
        sidebar.classList.add("sidebar");
        for (let contact of contacts) {
            let { idUser, userName, imgUser } = contact;

            const guid = guidGenerator();
            const contactDiv = document.createElement("div");
            contactDiv.id = guid;
            contactDiv.classList.add("contact");

            this.contacts[guid] = {
                "userName": userName,
                "idUser": idUser,
                "imgUser": imgUser,
                "messages": []
            };
            
            const userImg = document.createElement("img");
            userImg.src = imgUser ? imgUser : "images/temp/default-pic.png";
            // ADD TO CSS LATER
            userImg.style.width = "50px";
            
            const textDiv = document.createElement("div");
            textDiv.textContent = userName
            
            contactDiv.addEventListener("click", async (event) => {
                const contactDiv = event.currentTarget;
                const activeConversation = this.chatSidebar.querySelector("active");

                if (activeConversation) {
                    activeConversation.classList.remove("active");
                }

                contactDiv.classList.add("active");
                await this.changeContact(contactDiv.id);
            })

            contactDiv.appendChild(userImg);
            contactDiv.appendChild(textDiv);
            sidebar.prepend(contactDiv);
        }

        return sidebar;
    }

    async changeContact(contactId) {
        if (contactId === this.currContactGuid) {
            return;
        }

        let { idUser, userName, imgUser, messages } = this.contacts[contactId];
        let fetchMessages;
        this.currContactGuid = contactId;
        console.log(idUser, userName, imgUser, messages);

        // change conversationBox header (userName and imgUser)
        this.clearMessages();
        this.appendNewMessages(messages);

        this.messageLoading();
        fetchMessages = await getContactMessages(this.getCurrUserId());
        this.clearMessageLoading();

        this.appendNewMessages(fetchMessages);
        messages = [...messages, ...fetchMessages];
        this.contacts[contactId]["messages"] = messages;
    }

    getCurrUserId() {
        return this.contacts[this.currContactGuid]["idUser"];
    }

    appendNewMessages(messages) {
        if (!messages) {
            return;
        }

        const messagesDiv = this.conversationBox.querySelector(".messages");
        for (let msg of messages) {
            const { text, timestamp, sent } = msg;
            let message = document.createElement("div");
            message.textContent = text;

            // maybe doesn't works
            message.classList.add(sent ? "sent" : "received");

            // add timestamp styling
            console.log(`Text: ${text}\nTime: ${timestamp}\nSent: ${sent}`);
            
            messagesDiv.appendChild(message);
        }

        window.scrollTo(0, messagesDiv.body.scrollHeight);
    }

    prependOldMessages() {

    }

    clearMessages() {
        this.conversationBox.querySelector(".messages").innerHTML = "";
    }

    createMessageLoading() {

    }

    messageLoading() {
        console.log("loading...");
    }

    clearMessageLoading() {
        console.log("loaded");
    }
}

(async () => {
    const contacts = await getContacts();

    const chat = new chaThiago("#chat", contacts);
})();

/*
getContacts()

[0] => Array
    (
        [idUser] => 1
        [userName] => Mr White
        [imgUser] => null
    )

[1] => Array
    (
        [idUser] => 6
        [userName] => Thiago Neves Luz
        [imgUser] => null
    )

)
*/


/*

const contacts = {
    htmlElementGuid: {
        "userName": "Rafael Rodrigues",
        "idUser": 2,
        "messages": [
            { 
                "text": "Vai tomar no cu",
                "timestamp": "time",
                "sent": true
            },
            {
                "text": "Eai como estás",
                "timestamp": "ahoy brother",
                "sent": false
            }
        ]
    },
    htmlElementGuid: {
        "userName": "Thiago Neves",
        "idUser": 6,
        "messages": [
            { 
                "text": "Nossa mlk vai se foder pra krl",
                "timestamp": "time",
                "sent": true
            },
            {
                "text": "Puta merda",
                "timestamp": "ahoy brother",
                "sent": true
            }
        ]
    }
};
*/

async function sendMessage(idReceiver, message, timestamp) {
    let response = await fetch(
        `./php/post/chat/adicionarMensagem.php`,
        {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin",
            body: `idDestinatario=${idReceiver}&mensagem=${message}&timestamp=${timestamp}`,
        }
    );
    let data = await response.text();
    console.log(data);

    let { dados } = data;
    return dados;
}

async function getContacts() {
    let response = await fetch(
        `./php/post/chat/getConversas.php`,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin"
        }
    );
    let data = await response.json();
    
    let { dados } = data;
    return dados;
}

async function getContactMessages(idReceiver) {
    let response = await fetch(
        `./php/post/chat/getMensagensConversa.php`,
        {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin",
            body: `idDestinatario=${idReceiver}`,
        }
    );
    let data = await response.json();

    let { dados } = data;
    return dados;
}