/*
    
*/

class chaThiago {
    constructor(elementId, contacts) {
        this.chatSkeleton = this.createChatSkeleton(elementId);
        this.chatSidebar = this.createChatSidebar(contacts);
    }

    createChatSkeleton(elementId) {
        // const container = document.querySelector(`#${elementId}`);


        return "Skeleton";
    }

    createChatSidebar(contacts) {
        return contacts;
    }
}

const contacts = {
    "Rafael Rodrigues": {
        "userId": 2,
        "message": "last sent/received message",
    },
    "Thiago": {
        "userId": 2,
        "message": "vai tomar no cu",
    }
}

let chat = new chaThiago("#chat", contacts);
console.log(chat);