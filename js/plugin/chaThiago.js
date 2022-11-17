class chaThiago {
    constructor(elementId, contacts) {
        // data
        this.contacts = new Map();
        this.currentContact = null;

        // HTML elements
        this.chat = this.createChatSkeleton(elementId, contacts);
        this.conversationBox = chat.querySelector(`${elementId} .conversation-box`);
        this.chatSidebar = chat.querySelector(`${elementId} .sidebar`);

        // deal with sockets
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
        textingBox.classList.add("conversation-texting");
        const messagingForm = document.createElement("form");
        messagingForm.setAttribute("action", "javascript:void(0);");
        const messageInput = document.createElement("input");
        messageInput.classList.add("message-input");
        const sendMessageBtn = document.createElement("button");
        sendMessageBtn.innerHTML = "Send";

        messagingForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            // SEND MESSAGE
            console.log(messageInput.value);
            console.log(this.currentContact);
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

            this.contacts.set(guid, {
                "userName": userName,
                "idUser": idUser,
                "imgUser": imgUser,
                "messages": []
            })
            
            const userImg = document.createElement("img");
            userImg.src = imgUser ? imgUser : "images/temp/default-pic.png";
            // delete later
            userImg.style.width = "50px";
            
            const textDiv = document.createElement("div");
            textDiv.textContent = userName
            
            contactDiv.addEventListener("click", async (event) => {
                console.log(event.currentTarget);
                let contactId = event.currentTarget.id;
                // FETCH FOR MESSAGES
                this.currentContact = this.changeContact(this.contacts, contactId, this.conversationBox);
            })

            contactDiv.appendChild(userImg);
            contactDiv.appendChild(textDiv);
            sidebar.prepend(contactDiv);
        }

        return sidebar;
    }

    changeContact(contacts, contactId, conversationBox) {
        const { idUser, userName, imgUser, messages } = contacts.get(contactId);
        console.table(idUser, userName, imgUser, messages);

        // change conversationBox header (userName and imgUser)

        const messagesDiv = conversationBox.querySelector(".messages");
        messagesDiv.innerHTML = "";
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

        return idUser;
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

async function sendMessage(idReceiver, message) {
    let response = await fetch(
        `./php/post/chat/adicionarMensagem.php`,
        {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            credentials: "same-origin",
            body: `idDestinatario=${idReceiver}&mensagem=${message}`,
        }
    );
    let data = await response.json();

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