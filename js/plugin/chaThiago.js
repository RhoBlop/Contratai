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
        this.messagesBox = this.createChatSkeleton(elementId);
        this.chatSidebar = this.createChatSidebar(contacts);

        // data
        this.contacts;
    }

    createChatSkeleton(elementId) {
        // const container = document.querySelector(`#${elementId}`);


        return "Skeleton";
    }

    createChatSidebar(contacts) {
        return contacts;
    }
}


/*
const contacts = {
    htmlElement: {
        "userName": "Rafael Rodrigues",
        "userId": 2,
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
    htmlElement: {
        "userName": "Thiago Neves",
        "userId": 6,
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