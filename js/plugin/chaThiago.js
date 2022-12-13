//TODO ADD CONVERSATIONS WITH NEW USERS; NEW MESSAGES BADGE; VISUALIZED MESSAGES; FIX .messages HEIGHT WHEN CHAT IS INITIALIZED; STYLE CSS; ADD PAGINATION

class chaThiago {
    constructor(elementId, idUser, contacts) {
        this.liveChat = true;

        // data
        this.idSender = idUser;
        this.contacts = {};
        this.currContactId = null;
        this.maxMessagesPerFetch = 50;
        this.socket = this.liveChat ? this.setChatSocket() : null;
        
        // HTML elements
        this.messageLoadingRing = this.createMessageLoading();
        this.chat = this.createChatSkeleton(elementId, contacts);
        this.conversationBox = chat.querySelector(`${elementId} .conversation-box`);
        this.chatSidebar = chat.querySelector(`${elementId} .sidebar`);
    }

    setChatSocket() {
        let socket = io('https://contratai-chat.up.railway.app/', {
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
            
            if (idSender === this.currContactId) {
                this.appendNewMessages([ msg ]);
            }
        });

        socket.sendMessage = (message, timestamp) => {
            socket.emit("sendMessage", {
                idReceiver: this.currContactId,
                message: message,
                timestamp: timestamp
            });
        }

        // socket.setStatus = (status) => {
        //     allowedStatus = ["online", "offline", "digitando..."];
        //     if (allowedStatus.includes(status)) {
        //         if (status === "digitando...") {
        //             socket.emit("digitando", this.currContactId);
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
        container.classList.add("chathiago");
        
        return container;
    }

    createConversationBox() {
        const conversationBox = document.createElement("div");
        conversationBox.classList.add("conversation-box");
 
        const headerBox = document.createElement("div");
        headerBox.classList.add("conversation-header");
        
        const messagesDiv = document.createElement("div");
        messagesDiv.classList.add("messages");

        const emptyChatDiv = document.createElement("div");
        emptyChatDiv.classList.add("empty-chat");
        const emptyImg = document.createElement("img");
        emptyImg.src = "images/storyset/empty-chat.svg";
        const emptyTextDiv = document.createElement("h5");
        emptyTextDiv.innerHTML = "Entre em contato com qualquer usuário do Contrataí. Basta navegar pelos perfis de usuário e começar a negociar!";

        emptyChatDiv.appendChild(emptyTextDiv);
        emptyChatDiv.appendChild(emptyImg);
        messagesDiv.appendChild(emptyChatDiv);

        conversationBox.appendChild(headerBox);
        conversationBox.appendChild(messagesDiv);

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

            this.contacts[idUser] = {
                "userName": userName,
                "elementGuid": guid,
                "imgUser": imgUser,
                "messages": [],
                "offset": 0,
                "fetched": false
            };

            // ADD LAST SENT MESSAGE
            
            const userImg = document.createElement("img");
            userImg.src = imgUser ? imgUser : "images/temp/default-pic.png";
            
            const textDiv = document.createElement("div");
            textDiv.textContent = userName
            
            contactDiv.addEventListener("click", async (event) => {
                const contactDiv = event.currentTarget;
                const activeConversation = this.chatSidebar.querySelector(".active");

                if (activeConversation) {
                    activeConversation.classList.remove("active");
                }

                contactDiv.classList.add("active");
                await this.changeContact(this.getContactUserIdByGuid(contactDiv.id));
            })

            contactDiv.appendChild(userImg);
            contactDiv.appendChild(textDiv);
            sidebar.append(contactDiv);
        }

        return sidebar;
    }

    addMessageForm() {
        if (!this.conversationBox.querySelector(".texting-box")) {
            const textingBox = document.createElement("div");
            textingBox.classList.add("texting-box");

            const messagingForm = document.createElement("form");
            messagingForm.setAttribute("action", "javascript:void(0);");

            const emojiBtn = document.createElement("button");
            emojiBtn.innerHTML = '<i class="fa-solid fa-paperclip"></i>';

            const messageInput = document.createElement("input");
            messageInput.classList.add("message-input");
            messageInput.placeholder = "Digite sua mensagem...";
            messageInput.setAttribute("type", "text");

            const sendMessageBtn = document.createElement("button");
            sendMessageBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i>';

            messagingForm.addEventListener("submit", async (event) => {
                event.preventDefault();

                const input = event.currentTarget.querySelector("input");
                const message = input.value;
                
                if (message && this.currContactId) {
                    const idUser = this.currContactId;
                    const timestamp = dayjs().format('YYYY-MM-DD HH:mm:ss');
                    const msg = { text: message, timestamp: timestamp, sent: true };
                    this.addContactMessages(idUser, [ msg ]);
                    this.appendNewMessages([ msg ]);
                    if (this.liveChat) {
                        this.socket.sendMessage(message, timestamp);
                    }
                    input.value = "";
                    saveMessageDB(idUser, message, timestamp);
                }
            });

            messagingForm.appendChild(messageInput);
            messagingForm.appendChild(emojiBtn);
            messagingForm.appendChild(sendMessageBtn);
            textingBox.appendChild(messagingForm);
            this.conversationBox.appendChild(textingBox);
        }
    }

    async changeContact(contactId) {
        if (contactId === this.currContactId) {
            return;
        }
        
        this.addMessageForm();

        let { elementGuid, userName, imgUser, messages, offset, fetched } = this.contacts[contactId];
        this.currContactId = contactId;
        console.log(contactId, userName, imgUser, messages);

        const img = document.createElement("img");
        img.src = imgUser ? imgUser : "images/temp/default-pic.png";
        const textDiv = document.createElement("div");
        textDiv.innerHTML = userName;
        
        const headerDiv = this.conversationBox.querySelector(".conversation-header");
        headerDiv.innerHTML = "";
        headerDiv.appendChild(img);
        headerDiv.appendChild(textDiv);

        this.clearMessages();
        this.appendNewMessages(messages);

        if (!fetched) {
            this.messageLoading();
            let fetchMessages = await getContactMessages(contactId, this.maxMessagesPerFetch, offset);
            this.contacts[contactId]["fetched"] = true;
            this.clearMessageLoading();

            this.addContactMessages(contactId, fetchMessages)
            this.appendNewMessages(fetchMessages);
            
            this.scrollToBottom();
        }

    }

    appendNewMessages(messagesArr) {
        if (!messagesArr || messagesArr.length === 0) {
            return;
        }

        const messagesDiv = this.conversationBox.querySelector(".messages");
        for (let msg of messagesArr) {
            const { text, timestamp, sent } = msg;
            let message = document.createElement("div");
            message.textContent = text;

            message.classList.add(sent ? "sent" : "received");

            
            messagesDiv.appendChild(message);
        }

        this.scrollToBottom();
    }

    // prependOldMessages() {
        
    // }
    
    // changeNewMessagesBadge() {

    // }

    clearMessages() {
        this.conversationBox.querySelector(".messages").innerHTML = "";
    }

    getCurrReceiverGuid() {
        return this.contacts[this.currContactId]["elementGuid"];
    }

    getContactUserIdByGuid(guid) {
        for (let idUser in this.contacts) {
            if (this.contacts[idUser]["elementGuid"] === guid) {
                return idUser;
            }
        }

        return null;
    }

    // what if user is not in this.contacts? (socket.io)
    addContactMessages(idUser, messagesArr) {
        if (idUser && messagesArr.length !== 0) {
            this.contacts[idUser]["messages"] = [...this.contacts[idUser]["messages"], ...messagesArr];
            this.contacts[idUser]["offset"] += messagesArr.length;
        }
    }

    createMessageLoading() {
        const loadingRing = document.createElement("div");
        loadingRing.classList.add("lds-dual-ring");

        return loadingRing;
    }

    messageLoading() {
        this.conversationBox.querySelector(".messages").prepend(this.messageLoadingRing);
    }

    clearMessageLoading() {
        this.messageLoadingRing.remove();
    }

    scrollToBottom() {
        this.conversationBox.querySelector(".messages").scrollTop = this.conversationBox.querySelector(".messages").scrollHeight;
    }
}

(async () => {
    const [idUser, contacts] = await getContacts();

    console.log(contacts);
    const chat = new chaThiago("#chat", idUser, contacts);
})();

async function saveMessageDB(idReceiver, message, timestamp) {
    const urlEncoded = new URLSearchParams({
        idDestinatario: idReceiver,
        mensagem: message,
        timestamp: timestamp
    })

    let response = await fetch(
        `./php/post/chat/adicionarMensagem.php`,
        {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin",
            body: urlEncoded,
        }
    );
    let data = await response.json();

    return data.dados;
}

async function getContacts() {
    // checks in URL querystring for new contact
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
      });
    let idReceiver = params.newChatId;

    let queryString = "";
    if (idReceiver) {
        queryString = new URLSearchParams({
            "newUserId": idReceiver
        });

        // replace querystring from browser URL
        window.history.replaceState({}, document.title, "/" + "chat.php");
    }

    let response = await fetch(
        `./php/post/chat/getConversas.php?` + queryString,
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

async function getContactMessages(idReceiver, limit, offset) {
    const queryString = new URLSearchParams({
        idDestinatario: idReceiver,
        limit: limit,
        offset: offset
    })

    let response = await fetch(
        `./php/post/chat/getMensagensConversa.php?` + queryString,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin"
        }
    );
    let data = await response.json();

    return data.dados;
}

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