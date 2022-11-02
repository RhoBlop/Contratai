$(document).ready(function() {
    const inputEventos = document.querySelector("#eventos");
    let [ contratado, contratante ] = JSON.parse(inputEventos.value);
    let calendarEvents = [];

    // adicionando eventos de contratado
    for (let contrato of contratado) {
        let { idcontrato, nomeuser, descrespec, idstatus, descrstatus, descrcontrato, diacontrato, corcalendario } = contrato;

        let evento = {  
            "id": idcontrato,
            "name": "Contratado",
            "type": descrstatus,
            "description": `${nomeuser}
                            <br>Contrato: ${descrcontrato}
                            <br>Serviço: ${capitalizeFirstLetter(descrespec)}`,
            "date": diacontrato,
            "color": corcalendario,
        }

        calendarEvents.push(evento);
    }

    // adicionando eventos de contratante
    for (let contrato of contratante) {
        let { idcontrato, nomeuser, descrespec, idstatus, descrstatus, descrcontrato, diacontrato, corcalendario } = contrato;

        let evento = {  
            "id": idcontrato,
            "name": "Contratante",
            "type": descrstatus,
            "description": `${nomeuser}
                            <br>Contrato: ${descrcontrato}
                            <br>Serviço: ${capitalizeFirstLetter(descrespec)}`,
            "date": diacontrato,
            "color": corcalendario,
        }

        calendarEvents.push(evento);
    }

    $('#calendar').evoCalendar({
        'language': 'pt',
        'format': "yyyy/mm/dd",
        'todayHighlight': true,
        'sidebarDisplayDefault': false,
        'calendarEvents': calendarEvents
    })
})