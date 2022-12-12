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
                        <!-- SECTION - Contratante -->
                        <?php
                        include "components/card-contrato.php";
                        $idUser = $_SESSION["iduser"];

                        $contratosSolicitados = $usuarioClass->selectContratosContratante($idUser);

                        $solicitacoesEnviadas = [];
                        $emAndamentoEnviados = [];
                        $finalizadosEnviados = [];

                        // preenchendo as arrays de acordo com o status do contrato
                        foreach ($contratosSolicitados as $contrt) {
                            switch ($contrt["idstatus"]) {
                                case 1:
                                    $solicitacoesEnviadas[] = $contrt;
                                    break;
                                case 2:
                                    $emAndamentoEnviados[] = $contrt;
                                    break;
                                case 3:
                                    $emAndamentoEnviados[] = $contrt;
                                    break;
                                case 5:
                                    $emAndamentoEnviados[] = $contrt;
                                    break;
                                case 4:
                                    $finalizadosEnviados[] = $contrt;
                            }
                            
                        }


                        ?>

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
                                        <?php
                                        if (empty($solicitacoesEnviadas)) :
                                            constructNullCard();
                                        else :
                                            foreach ($solicitacoesEnviadas as $contrt) :
                                                $idUsr = $contrt['iduser'];
                                                $imgPerfil = $contrt["imguser"];
                                                $headerMsg = "Você enviou uma solicitação para <b>{$contrt["nomeuser"]}</b>!";
                                                $especializacao = ucfirst($contrt["descrespec"]);
                                                $diasContrato = $contrt["diascontrato"];
                                                $descrContrato = $contrt["descrcontrato"];
                                                $botoes = [];
                                                $aviso = "Aguarde o usuário aceitar ou rejeitar seu pedido";
                                                $dataCriacao = $contrt["timecriacaocontrato"];
                                                $idContrato = $contrt["idcontrato"];

                                                echo constructContratoCard($idUsr, $imgPerfil, $headerMsg, $especializacao, $diasContrato, $descrContrato, $botoes, $aviso, $dataCriacao, $idContrato);
                                            endforeach;
                                        endif;
                                        ?>
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
                                        <?php
                                        if (empty($emAndamentoEnviados)) :
                                            constructNullCard();
                                        else :
                                            foreach ($emAndamentoEnviados as $contrt) :
                                                $idUsr = $contrt['iduser'];
                                                $imgPerfil = $contrt["imguser"];
                                                $especializacao = ucfirst($contrt["descrespec"]);
                                                $diasContrato = $contrt["diascontrato"];
                                                $descrContrato = $contrt["descrcontrato"];
                                                $dataCriacao = $contrt["timecriacaocontrato"];
                                                $idContrato = $contrt["idcontrato"];
                                                
                                                if ($contrt["idstatus"] === 2):
                                                    $headerMsg = "O Contrato com <b>{$contrt["nomeuser"]}</b> está em andamento";
                                                    $botoes = [];
                                                    $aviso = "Após o usuário contratado finalizar o contrato você poderá avaliá-lo!";

                                                elseif ($contrt["idstatus"] === 3):
                                                    $headerMsg = "<b>{$contrt["nomeuser"]}</b> solicitou o fim do contrato. Clique no botão abaixo caso o serviço tenha sido cumprido.";
                                                    $botoes = [
                                                        ["O Contrato foi finalizado!", "aceitarFimContrato(event)"]
                                                    ];
                                                    $aviso = "";

                                                elseif ($contrt["idstatus"] === 5):
                                                    $headerMsg = "Infelizmente as datas do contrato com <b>{$contrt["nomeuser"]}</b> expiraram e o contrato não foi finalizado pelo contratado. Caso isso não tenha sido combinado entre os dois, você pode agora avaliá-lo.";
                                                    $botoes = [
                                                        ["Avaliar", "", "modal"]
                                                    ];
                                                    $aviso = "";
                                                endif;

                                                
                                                echo constructContratoCard($idUsr, $imgPerfil, $headerMsg, $especializacao, $diasContrato, $descrContrato, $botoes, $aviso, $dataCriacao, $idContrato);

                                            endforeach;
                                        endif;
                                        ?>
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
                                    <div>
                                        <?php
                                        if (empty($finalizadosEnviados)) :
                                            constructNullCard();
                                        else :
                                            foreach ($finalizadosEnviados as $contrt) :
                                                $idUsr = $contrt['iduser'];
                                                $imgPerfil = $contrt["imguser"];
                                                $dataFinalizado = returnFullDate($contrt["timefinalizacaocontrato"]);
                                                $headerMsg = "O Contrato com <b>{$contrt["nomeuser"]}</b> foi finalizado em {$dataFinalizado}.";
                                                $especializacao = ucfirst($contrt["descrespec"]);
                                                $diasContrato = $contrt["diascontrato"];
                                                $descrContrato = $contrt["descrcontrato"];
                                                $dataCriacao = $contrt["timecriacaocontrato"];
                                                $idContrato = $contrt['idcontrato'];

                                                if (!$contrt["isavaliado"]) :
                                                    $botoes = [
                                                        ["Avaliar", "", "modal"]
                                                    ];
                                                    $aviso = "";
                                                else :
                                                    $botoes = [];
                                                    $aviso = "O contrato já foi avaliado!";
                                                endif;

                                                echo constructContratoCard($idUsr, $imgPerfil, $headerMsg, $especializacao, $diasContrato, $descrContrato, $botoes, $aviso, $dataCriacao, $idContrato);
                                            
                                                include("components/modal-avaliacao.php");
                                            
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Finalizados -->
                        </div>
                        <!-- !SECTION - Contratante -->

                        <!-- SECTION - Profissional -->
                        <?php

                        $contratosRecebidos = $usuarioClass->selectContratosProfissional($idUser);

                        $solicitacoesRecebidas = [];
                        $emAndamentoRecebidos = [];
                        $finalizadosRecebidos = [];

                        // preenchendo as arrays de acordo com o status do contrato
                        foreach ($contratosRecebidos as $contrt) {
                            switch ($contrt["idstatus"]) {
                                case 1:
                                    $solicitacoesRecebidas[] = $contrt;
                                    break;
                                case 2:
                                case 3:
                                case 5:
                                    $emAndamentoRecebidos[] = $contrt;
                                    break;
                                case 4:
                                    $finalizadosRecebidos[] = $contrt;
                            }
                        }
                        ?>

                        <div class="accordion accordion-flush tab-pane fade" id="contratado-pane" role="tabpanel">

                            <!-- SECTION - Solicitações -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#solicitacoesContratado" aria-expanded="true" aria-controls="solicitacoesContratado">
                                        Solicitações de contrato recebidas
                                    </button>
                                </h2>
                                <div id="solicitacoesContratado" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contratado-pane">
                                    <?php
                                    if (empty($solicitacoesRecebidas)) :
                                        constructNullCard();
                                    else :
                                        foreach ($solicitacoesRecebidas as $contrt) :
                                            $idUsr = $contrt['iduser'];
                                            $imgPerfil = $contrt["imguser"];
                                            $headerMsg = "<b>{$contrt["nomeuser"]}</b> quer te contratar!";
                                            $especializacao = ucfirst($contrt["descrespec"]);
                                            $diasContrato = $contrt["diascontrato"];
                                            $descrContrato = $contrt["descrcontrato"];
                                            $botoes = [
                                                ["Aceitar", "aceitarContrato(event)"],
                                                ["Recusar", "recusarContrato(event)"]
                                            ];
                                            $aviso = "";
                                            $dataCriacao = $contrt["timecriacaocontrato"];
                                            $idContrato = $contrt['idcontrato'];

                                            echo constructContratoCard($idUsr, $imgPerfil, $headerMsg, $especializacao, $diasContrato, $descrContrato, $botoes, $aviso, $dataCriacao, $idContrato);
                                        
                                        endforeach;
                                    endif;
                                    ?>
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
                                        <?php
                                        if (empty($emAndamentoRecebidos)) :
                                            constructNullCard();
                                        else :
                                            foreach ($emAndamentoRecebidos as $contrt) :
                                                $idUsr = $contrt['iduser'];
                                                $imgPerfil = $contrt["imguser"];
                                                $especializacao = ucfirst($contrt["descrespec"]);
                                                $diasContrato = $contrt["diascontrato"];
                                                $descrContrato = $contrt["descrcontrato"];
                                                $dataCriacao = $contrt["timecriacaocontrato"];
                                                $idContrato = $contrt["idcontrato"];

                                                if ($contrt['idstatus'] === 2) :
                                                    $headerMsg = "O Contrato com <b>{$contrt["nomeuser"]}</b> está em andamento";
                                                    $botoes = [
                                                        ["Contrato realizado!", "solicitarFimContrato(event)"]
                                                    ];
                                                    $aviso = "Clique no botão abaixo caso o serviço tenha sido finalizado.";
                                                
                                                elseif ($contrt['idstatus'] === 3 ) :
                                                    $headerMsg = "Você enviou uma solicitação ao contratante <b>{$contrt["nomeuser"]}</b> para finalizar o contrato.";
                                                    $botoes = [];
                                                    $aviso = "Aguarde o contratante aceitar sua solicitação";
                                                
                                                elseif ($contrt['idstatus'] === 5) :
                                                    $headerMsg = "Você não finalizou o contrato com <b>{$contrt["nomeuser"]}</b> dentro da data prevista. O contrante agora pode avaliar seu serviço.";
                                                    $botoes = [];
                                                    $aviso = "[Por enquanto não é possível realizar nenhuma ação enquanto o contrato está atrasado]";
                                                        
                                                endif;
                                                echo constructContratoCard($idUsr, $imgPerfil, $headerMsg, $especializacao, $diasContrato, $descrContrato, $botoes, $aviso, $dataCriacao, $idContrato);
                                            endforeach;
                                        endif;
                                        ?>
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
                                        <?php
                                        if (empty($finalizadosRecebidos)) :
                                            constructNullCard();
                                        else :
                                            foreach ($finalizadosRecebidos as $contrt) :
                                                $idUsr = $contrt['iduser'];
                                                $imgPerfil = $contrt["imguser"];
                                                $dataFinalizado = returnFullDate($contrt["timefinalizacaocontrato"]);
                                                $headerMsg = "O Contrato com <b>{$contrt["nomeuser"]}</b> foi finalizado em <b>{$dataFinalizado}</b>.";
                                                $especializacao = ucfirst($contrt["descrespec"]);
                                                $diasContrato = $contrt["diascontrato"];
                                                $descrContrato = $contrt["descrcontrato"];
                                                $botoes = [];
                                                $dataCriacao = $contrt["timecriacaocontrato"];
                                                $idContrato = $contrt['idcontrato'];

                                                if (!$contrt["isavaliado"]) :
                                                    $aviso = "O Contratante agora pode avaliar o contrato, aguarde até que ele faça isso.";
                                                else :
                                                    $aviso = "O Contrato já foi avaliado!";
                                                endif;
                                                echo constructContratoCard($idUsr, $imgPerfil, $headerMsg, $especializacao, $diasContrato, $descrContrato, $botoes, $aviso, $dataCriacao, $idContrato);
                                            
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Finalizados -->
                            </div>
                        </div>

                        <!-- !SECTION - Profissional -->

                        <!-- SECTION Agenda  -->
                        <?php
                            $eventos = json_encode($usuarioClass->selectCalendario($idUser));
                        ?>
                        <input id="eventos" type="hidden" value='<?php echo $eventos; ?>'>

                        <div class="agenda my-5">
                            <h2>Agenda</h2>
                            <h6 class="text-muted">Veja quais são seus próximos compromissos</h6>
                            <!-- SECTION - Calendário -->
                            <div id="calendar" class="my-4"></div>
                            <!-- !SECTION - Calendário -->
                            
                            <!-- SECTION - Legenda --> 
                            <h5>Legenda</h5>
                            <?php
                                require("php/database/Contrato.php");
                                $contratoClass = new Contrato();
                                $legenda = $contratoClass->selectLegendaCalendario();

                                foreach($legenda as $status) {
                                    $descr = ucfirst($status['descrstatus']);
                                    echo <<<HTML
                                        <div class="item">
                                            <div class="square" style="background-color:{$status['corcalendario']}"></div>
                                            <p>{$descr}</p>
                                        </div>
                                    HTML;
                                }
                            ?>
                            <!-- !SECTION - Legenda -->
                        </div>
                        <!-- !SECTION Agenda -->
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

<!-- Initializes Evo-Calendar -->
<script src="js/loadCalendar.js"></script>
</html>