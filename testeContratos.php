<!DOCTYPE html>
<html lang="en">

<head>

    <!-- EVO CALENDAR CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="css/evo-calendar.css" />
    
    <?php require("components/head.php") ?>
    <script src="js/fetch/statusContratos.js"></script>

</head>

<body>
    <?php include("components/header-auth.php");?>

    <main>
        <div class="container p-3 my-3">
            <div class="row gx-5">

                <?php include("components/sidebar.php") ?>

                <div class="col-10 px-4 d-flex flex-column" id="settingsContent">
                    <!-- TODO Colocar a descrição dos contratos nos accordions e ajeitar as boxes de datas -->
                    <div class="mb-4">
                        <h2>Meus contratos</h2>
                        <h6 class="text-muted">Aceite solicitações de contratos, visualize os que estão em andamento e finalize-os</h6>
                    </div>

                    <div class="nav nav-justified filter-tablist rounded-3 mb-3" id="tablist" role="tablist">
                        <a class="nav-link active" id="contratante-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratante-pane" role="tab">Contratei</a>
                        <a class="nav-link" id="contratado-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratado-pane" role="tab">Contratado</a>
                    </div>
                    <div class="tab-content">
                        <div class="accordion accordion-flush tab-pane fade show active" id="contratante-pane" role="tabpanel">

                            <!-- SECTION - Solicitações -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#solicitacoesContratante" aria-expanded="true" aria-controls="solicitacoesContratante">
                                        Solicitações de contrato enviadas
                                    </button>
                                </h2>
                                <div id="solicitacoesContratante" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contratante-pane">
                                    <div>
                                        <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                            <div class="d-flex gap-3">
                                                <div class="clickable-image">
                                                    <img src="images/temp/default-pic.png">
                                                </div>
                                                <div class="text">
                                                    <h8>Você enviou uma solicitação para <b>Nome</b>!</h8>

                                                    <p class="text-muted">Profissão:</p>
                                                    <div class="contract-dates my-2">
                                                        <p class="text-muted">Dias agendados:</p>
                                                        <div class="date-chip">
                                                            28 de agosto
                                                        </div>
                                                    </div>
                                                    <p>Aguarde o usuário aceitar ou rejeitar seu pedido</p>
                                                </div>
                                            </div>
                                            <div class="time text-end">
                                                <p class="text-muted">Time elapsed</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Solicitações -->

                            <!-- SECTION - Em andamento -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emAndamentoContratante" aria-expanded="false" aria-controls="emAndamentoContratante">
                                        Contratos em andamento
                                    </button>
                                </h2>
                                <div id="emAndamentoContratante" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contratante-pane">
                                    <div>
                                        <div>Contrato em andamento (2)</div>
                                        <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                            <div class="d-flex gap-3">
                                                <div class="clickable-image">
                                                    <img src="images/temp/default-pic.png">
                                                </div>
                                                <div class="text">
                                                    <h8>O contrato com <b>Nome</b> está em andamento.</h8>

                                                    <p class="text-muted">Profissão:</p>
                                                    <div class="contract-dates my-2">
                                                        <p class="text-muted">Dias agendados:</p>
                                                        <div class="date-chip">
                                                            30 de agosto
                                                        </div>
                                                    </div>

                                                    <p>Após o usuário contratado finalizar o contrato você poderá avaliá-lo!</p>
                                                </div>
                                            </div>

                                            <p class="text-muted">Time elapsed</p>
                                        </div>

                                        

                                        <div>Solicitação de fim de contrato (3)</div>
                                            <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                                <div class="d-flex gap-3">
                                                    <div class="clickable-image">
                                                        <img src="images/temp/default-pic.png">
                                                    </div>
                                                    <div class="text">
                                                        <h8>O contratado <b>Nome</b> solicitou o fim do contrato. Caso ele tenha cumprido o serviço oferecido, clique no botão abaixo.</h8>
                                            
                                                        <p class="text-muted">Profissão:</p>
                                                        <div class="contract-dates my-1">
                                                            <p class="text-muted">Dias agendados:</p>
                                                            <div class="date-chip">
                                                                31 de agosto
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="contrato-buttons my-2 d-flex gap-2">
                                                            <button class="btn btn-outline-green" onclick="aceitarFimContrato(event)">O contrato foi realizado!</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="text-muted">Time elapsed</p>
                                            </div>

                                            
                                        <div>Atrasado (6)</div>
                                            <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                                <div class="d-flex gap-3">
                                                    <div class="clickable-image">
                                                        <img src="images/temp/default-pic.png">
                                                    </div>
                                                    <div class="text">
                                                        <h8>Infelizmente as datas do contrato com <b>Nome</b> expiraram e o contrato não foi finalizado pelo contratado. Caso isso não tenha sido combinado entre os dois, você pode agora avaliá-lo.</h8>
                                            
                                                        <p class="text-muted">Profissão:</p>
                                                        <div class="contract-dates my-1">
                                                            <p class="text-muted">Dias agendados:</p>
                                                            <div class="date-chip">
                                                                01 de setembro
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="contrato-buttons my-2 d-flex gap-2">
                                                            <button type="button" class="btn btn-green px-2" data-bs-toggle="modal">Avaliar</button>

                                                            <p class="text-muted">Você já avaliou esse contrato.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="text-muted">Time elapsed</p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Em andamento -->
            
                            <!-- SECTION - Finalizados -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalizadosContratante" aria-expanded="false" aria-controls="finalizadosContratante">
                                        Contratos finalizados
                                    </button>
                                </h2>
                                <div id="finalizadosContratante" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#contratante-pane">
                                    <div>Finalizado (6 - Sem avaliação)</div>
                                    <div>
                                        <div class="id-contrato accordion-body d-flex align-items-start gap-3">
                                            <div class="clickable-image">
                                                <img src="images/temp/default-pic.png">
                                            </div>
                                            <div class="text">
                                                <h8>O contrato com <b>Nome</b> foi finalizado em <b>Data</b>. Agora você pode avaliá-lo pelo serviço!</h8>

                                                <p class="text-muted">Profissão:</p>
                                                <div class="contract-dates my-1">
                                                    <p class="text-muted">Dias agendados:</p>
                                                    <div class="date-chip">28 de agosto</div>
                                                </div>

                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                    <a type="button" class="btn btn-green px-2" data-bs-toggle="modal">Avaliar</a>
                                                </div>
                                            </div>

                                            <p class="text-muted">Time elapsed</p>
                                        </div>

                                        <!-- MODAL DE AVALIAÇÃO -->
                                        <?php
                                            include("components/modal-avaliacao.php");
                                        ?>
                                    </div>

                                    <div>Finalizado (6 - Avaliado)</div>
                                    <div>
                                        <div class="id-contrato accordion-body d-flex align-items-start gap-3">
                                            <div class="clickable-image">
                                                <img src="images/temp/default-pic.png">
                                            </div>
                                            <div class="text">
                                                <h8>O contrato com <b>Nome</b> foi finalizado em <b>Data</b>. Agora você pode avaliá-lo pelo serviço!</h8>

                                                <p class="text-muted">Profissão:</p>
                                                <div class="contract-dates my-1">
                                                    <p class="text-muted">Dias agendados:</p>
                                                    <div class="date-chip">28 de agosto</div>
                                                </div>

                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                    <p class="text-muted">Você já avaliou esse contrato!</p>
                                                </div>
                                            </div>

                                            <p class="text-muted">Time elapsed</p>
                                        </div>

                                        <!-- MODAL DE AVALIAÇÃO -->
                                        <?php
                                            include("components/modal-avaliacao.php");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Finalizados -->
                        </div>
                        <!-- !SECTION - Contratante -->

                        <!-- SECTION - Profissional -->
                        <div class="accordion accordion-flush tab-pane fade" id="contratado-pane" role="tabpanel">

                            <!-- SECTION - Solicitações -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#solicitacoesContratado" aria-expanded="true" aria-controls="solicitacoesContratado">
                                        Solicitações de contrato recebidas
                                    </button>
                                </h2>
                                <div id="solicitacoesContratado" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contratado-pane">
                                    <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                        <div class="d-flex gap-3">
                                            <div class="clickable-image">
                                                <img src="images/temp/default-pic.png">
                                                
                                            </div>
                                            <div class="text">
                                                <h8><b>Nome</b> quer te contratar!</h8>

                                                <p class="text-muted">Profissão: </p>
                                                <div class="contract-dates my-2">
                                                    <p class="text-muted">Dias agendados:</p>
                                                    <div class="date-chip">28 de agosto</div>
                                                </div>

                                                <div class="contrato-buttons my-3 d-flex gap-2">
                                                    <button class="btn btn-green" onclick="aceitarContrato(event)">Aceitar</button>
                                                    <button class="btn btn-outline-dark" onclick="recusarContrato(event)">Recusar</button>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="text-muted">Time elapsed</p>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Solicitações -->

                            <!-- SECTION - Em andamento -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emAndamentoContratado" aria-expanded="false" aria-controls="emAndamentoContratado">
                                        Contratos em andamento
                                    </button>
                                </h2>
                                <div id="emAndamentoContratado" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contratado-pane">
                                    <div>
                                        <div>Contratos em andamento</div>
                                        <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                            <div class="d-flex gap-3">
                                                <div class="clickable-image">
                                                    <img src="images/temp/default-pic.png">
                                                    
                                                </div>
                                                <div class="text">
                                                    <h8 class="m-0">O contrato com <b>Nome</b> está em andamento! Quando você terminar o serviço, clique no botão abaixo para solicitar o fim do contrato ao usuário.</h8>
                                                    
                                                    <p class="text-muted">Profissão: </p>
                                                    <div class="contract-dates my-2">
                                                        <p class="text-muted">Dias agendados:</p>
                                                        <div class="date-chip">
                                                            28 de agosto
                                                        </div>
                                                    </div>

                                                    <div class="contrato-buttons my-2 d-flex gap-2">
                                                        <button onclick="solicitarFimContrato(event)" class="btn btn-outline-green">O contrato foi realizado!</button>
                                                    </div>
                                                </div>
                                                <div class="time text-end">
                                                    <p class="text-muted">Time elapsed</p>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div>Solicitação finalização</div>
                                        <div class="id-contrato accordion-body d-flex align-items-start justify-content-between">
                                            <div class="d-flex gap-3">
                                                <div class="clickable-image">
                                                    <img src="images/temp/default-pic.png">
                                                </div>
                                                <div class="text">
                                                    <h8 class="m-0">Você enviou uma solicitação ao contratante <b>Nome</b> para finalizar o contrato.</h8>
                                                    
                                                    <p class="text-muted">Profissão: </p>
                                                    <div class="contract-dates my-2">
                                                        <p class="text-muted">Dias agendados:</p>
                                                        <div class="date-chip">28 de agosto</div>
                                                    </div>
                                                    <p>Aguarde o contratante aceitar sua solicitação</p>
                                                </div>
                                            </div>
                                            <p class="text-muted">Time elapsed</p>
                                        </div>

                                        <div>Contrato recusado</div>
                                        <div class="id-contrato accordion-body d-flex align-items-start gap-3">
                                            <div class="clickable-image">
                                                <img src="images/temp/default-pic.png">
                                                
                                            </div>
                                            <div class="text">
                                                <h8 class="m-0">Você não finalizou o contrato com <b>Nome</b> dentro da data prevista. O usuário contratante pode agora avaliá-lo por seu serviço.</h8>
                                                
                                                <p class="text-muted">Profissão: </p>
                                                <div class="contract-dates my-2">
                                                    <p class="text-muted">Dias agendados:</p>
                                                    <div class="date-chip">
                                                        28 de agosto
                                                    </div>
                                                </div>

                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                    [Por enquanto não é possível realizar nenhuma ação enquanto o contrato está atrasado]
                                                    <!-- <button onclick="solicitarFimContrato(event)" class="btn btn-green">O contrato foi realizado!</button> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time text-end">
                                            <p class="text-muted">Time elapsed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Em andamento -->

                            <!-- SECTION - Finalizados -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalizadosContratado" aria-expanded="false" aria-controls="finalizadosContratado">
                                        Contratos finalizados
                                    </button>
                                </h2>
                                <div id="finalizadosContratado" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#contratado-pane">
                                    <div>
                                        <div class="id-contrato accordion-body d-flex align-items-start gap-3">
                                            <div class="clickable-image">
                                                <img src="images/temp/default-pic.png">
                                            </div>
                                            <div class="text">
                                                <h7 class="m-0">O contrato com <b>Nome</b> foi finalizado com sucesso em <b>Time</b>!</h7>
                                                
                                                <p class="text-muted">Profissão: </p>
                                                <div class="contract-dates my-2">
                                                    <p class="text-muted">Dias agendados:</p>
                                                    <div class="date-chip">28 de agosto</div>
                                                </div>

                                                <div class="contrato-buttons my-2 d-flex gap-2">

                                                    <p class="text-muted">O contrante pode agora avaliar o contrato!</p>


                                                    <p class="text-muted">O contrato já foi avaliado!</p>
                                                    <!-- //TODO - Adicionar modal com a avaliação feita pelo usuário -->
                                                </div>

                                                
                                            </div>

                                            <p class="text-muted">Time elapsed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Finalizados -->
                            </div>
                        </div>

                        <!-- !SECTION - Profissional -->
                    </div>
                </div>
            </div>
    </main>

    <!-- Add jQuery library (required) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="js/plugin/evoCalendar.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</html>