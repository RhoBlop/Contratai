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

    return data;
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

    return data;
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

    return data;
}

class chaThiago {
    constructor(elementId, contacts) {
        // HTML elements
        this.chat = this.createChatSkeleton(elementId, contacts);
        this.messagesBox = chat.querySelector(`${elementId} .messages`);
        this.chatSidebar = chat.querySelector(`${elementId} .sidebar`);

        // data
        this.contacts = new Map();

        // deal with sockets
    }

    createChatSkeleton(elementId, contacts) {
        const container = document.querySelector(elementId);
        const sidebar = this.createChatSidebar(contacts);

        container.appendChild(sidebar);

        return container;
    }

    createChatSidebar(contacts) {
        const sidebar = document.createElement("div");
        for (contact of contacts) {
            let { idUser, userName, imgUser } = contact;

            const guid = guidGenerator();
            const contactDiv = document.createElement("div");
            contactDiv.id = guid;

            this.contacts.set(guid, {
                "userName": userName,
                "idUser": idUser,
                "messages": []
            })
            
            const userImg = document.createElement("img");
            userImg.src = imgUser
            
            const textDiv = document.createElement("div");
            textDiv.textContent = userName
            
            contactDiv.addEventListener("click", () => {
                // change message box accordingly to contact id
            })

            contactDiv.appendChild(userImg);
            contactDiv.appendChild(textDiv);
            sidebar.prepend(contactDiv);
        }

        return sidebar;
    }

    changeMessageBox(idUser) {

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
let chat = new chaThiago("#chat", contacts);
console.log(chat);