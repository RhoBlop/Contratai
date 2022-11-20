//TODO ADD CONVERSATIONS WITH NEW USERS; NEW MESSAGES BADGE; VISUALIZED MESSAGES; STYLE CSS; ADD PAGINATION

class chaThiago {
    constructor(elementId, idUser, contacts) {
        // data
        this.idSender = idUser;
        this.contacts = {};
        this.currContactGuid = null;
        this.socket = this.setChatSocket();
        
        // HTML elements
        this.fetchMessageLoading = this.createMessageLoading();
        this.chat = this.createChatSkeleton(elementId, contacts);
        this.conversationBox = chat.querySelector(`${elementId} .conversation-box`);
        this.chatSidebar = chat.querySelector(`${elementId} .sidebar`);
    }

    setChatSocket() {
        let socket = io('https://contrataiwsserver.up.railway.app', {
            transports: ['websocket'],
            withCredentials: true,
        });

        socket.on("connect", () => {
            console.log("Socket connected");
        })
        socket.on("disconnect", (reason) => {
            console.log(reason);
        });

        socket.emit("setSocketId", this.idSender);
        socket.on("newMessage", (messageJson) => {
            const { idSender, message, timestamp, sent } = messageJson
            const msg = {
                text: message,
                time: timestamp,
                sent: sent
            };

            this.addContactMessages(idSender, [ msg ]);
            
            if (idSender === this.getCurrReceiverId()) {
                this.appendNewMessages([ msg ]);
            }
        });

        socket.sendMessage = (message, timestamp) => {
            socket.emit("sendMessage", {
                idReceiver: this.getCurrReceiverId(),
                message: message,
                timestamp: timestamp
            });
        }

        // socket.setStatus = (status) => {
        //     allowedStatus = ["online", "offline", "digitando..."];
        //     if (allowedStatus.includes(status)) {
        //         if (status === "digitando...") {
        //             socket.emit("digitando", this.getCurrReceiverId());
        //         } else {
        //             socket.emit(status);
        //         }
        //     }
        // }

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

        messagingForm.addEventListener("submit", this.sendMessageForm);

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
            let { idUser, userName, imgUser, lastMessage, timestamp } = contact;

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

            // ADD LAST SENT MESSAGE
            
            const userImg = document.createElement("img");
            userImg.src = imgUser ? imgUser : "images/temp/default-pic.png";
            // ADD TO CSS LATER
            userImg.style.width = "48px";
            
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

    async sendMessageForm(event) {
        event.preventDefault();

        const input = event.currentTarget.querySelector("input");
        const message = input.value;
        
        if (message && this.contacts) {
            const idUser = this.getCurrReceiverId();
            const timestamp = dayjs().format('YYYY-MM-DD HH:mm:ss');
            const msg = { text: message, timestamp: timestamp, sent: true };
            this.addContactMessages(idUser, [ msg ]);
            this.appendNewMessages([ msg ]);
            this.socket.sendMessage(message, timestamp);
            input.value = "";
            saveMessageDB(idUser, message, timestamp);
        }
    }

    async changeContact(contactId) {
        if (contactId === this.currContactGuid) {
            return;
        }

        let { idUser, userName, imgUser, messages } = this.contacts[contactId];
        this.currContactGuid = contactId;
        console.log(idUser, userName, imgUser, messages);

        // change conversationBox header (userName and imgUser)
        this.clearMessages();
        this.appendNewMessages(messages);

        this.messageLoading();
        let fetchMessages = await getContactMessages(idUser);
        this.clearMessageLoading();

        this.addContactMessages(idUser, fetchMessages)
        this.appendNewMessages(fetchMessages);
    }

    appendNewMessages(messagesArr) {
        if (!messagesArr) {
            return;
        }

        const messagesDiv = this.conversationBox.querySelector(".messages");
        for (let msg of messagesArr) {
            const { text, timestamp, sent } = msg;
            let message = document.createElement("div");
            message.textContent = text;

            // maybe doesn't works
            message.classList.add(sent ? "sent" : "received");

            // add timestamp styling
            console.log(`Text: ${text}\nTime: ${timestamp}\nSent: ${sent}`);
            
            messagesDiv.appendChild(message);
        }

        // will this work?
        window.scrollTo(0, messagesDiv.scrollHeight);
    }

    // prependOldMessages() {
        
    // }
    
    // changeNewMessagesBadge() {

    // }

    clearMessages() {
        this.conversationBox.querySelector(".messages").innerHTML = "";
    }

    getCurrReceiverId() {
        return this.contacts[this.currContactGuid]["idUser"];
    }

    getContactGuidByUserId(idUser) {
        for (let guid in this.contacts) {
            if (this.contacts[guid]["idUser"] === idUser) {
                return guid;
            }
        }

        return null;
    }

    // what if user is not in this.contacts? (socket.io)
    addContactMessages(idUser, messagesArr) {
        const contactGuid = this.getContactGuidByUserId(idUser);

        if (contactGuid) {
            this.contacts[contactGuid]["messages"] = [...this.contacts[contactGuid]["messages"], ...messagesArr];
        }
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
    const [idUser, contacts] = await getContacts();

    const chat = new chaThiago("#chat", idUser, contacts);
})();

/*
getContacts()

[idUser] => 2
[0] => Array
    (
        [idUser] => 1
        [userName] => Mr White
        [imgUser] => null
        [textoMensagem]
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

async function saveMessageDB(idReceiver, message, timestamp) {
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
    let data = await response.json();

    return data.dados;
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
    return [ dados.idUser, dados.contacts ];
}

async function getNewContact(idReceiver) {
    let response = await fetch(
        `./php/post/chat/getMensagensConversa.php`,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin",
            body: `idDestinatario=${idReceiver}`,
        }
    );
    let data = await response.json();

    return data.dados;
}

async function getContactMessages(idReceiver) {
    let response = await fetch(
        `./php/post/chat/getMensagensConversa.php`,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin",
            body: `idDestinatario=${idReceiver}`,
        }
    );
    let data = await response.json();

    return data.dados;
}