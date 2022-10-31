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
    <?php include("components/auth-header.php") ?>

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


                    <!-- REVIEW Ajeitar a borda que ta muito zuada -->
                    <div class="nav nav-justified filter-tablist rounded-3 mb-3" id="tablist" role="tablist">
                        <a class="nav-link active" id="contratante-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratante-pane" role="tab">Contratei</a>
                        <a class="nav-link" id="contratado-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratado-pane" role="tab">Contratado</a>
                    </div>
                    <div class="tab-content">


                        <!-- SECTION - Contratante -->
                        <?php
                        $idUser = $_SESSION["iduser"];

                        $solicitacoesRecebidas = $usuarioClass->selectContratosContratante($idUser, 1);
                        $emAndamento = $usuarioClass->selectContratosContratante($idUser, 2);
                        $finalizados = $usuarioClass->selectContratosContratante($idUser, 3);
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
                                        if (empty($solicitacoesRecebidas)) :
                                            echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhuma solicitação de contratação pendente.</span></div>
                                        ERROR;
                                        else :
                                            foreach ($solicitacoesRecebidas as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid="<?php echo $contrt["idcontrato"]; ?>">
                                                    <div class="d-flex gap-3">
                                                        <div class="clickable-image">
                                                            <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                            <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                        </div>
                                                        <div class="text">
                                                            <h8>Você enviou uma solicitação para <b><?php echo $contrt["nomeuser"] ?></b>!</h8>
                                                            <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                            <p>Dias agendados:</p>
                                                            <div class="contract-dates my-2">
                                                                <?php
                                                                foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                    echo '<div class="date-chip">';
                                                                    echoMediumDate($diacontrato);
                                                                    echo '</div>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <p>Aguarde o usuário aceitar ou rejeitar seu pedido</p>
                                                        </div>
                                                    </div>
                                                    <div class="time text-end">
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>
                                                    </div>
                                                </div>

                                        <?php
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
                                        if (empty($emAndamento)) :
                                            echo <<<ERROR
                                                <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span></div>
                                            ERROR;
                                        else :
                                            foreach ($emAndamento as $contrt) :
                                        ?>
                                                <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"] ?></b> está em andamento! Após o fim das datas previstas você poderá avaliá-lo.</h7>
                                                        <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                        <div class="accordion-buttons my-2 d-flex gap-2">
                                                            <button onclick="solicitarFimContrato(event)" class="btn btn-green">O contrato foi realizado!</button>
                                                        </div>
                                                    </div>

                                                    <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                </div>
                                        <?php
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
                                        if (empty($finalizados)) :
                                            echo <<<ERROR
                                                <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span>.</div>
                                            ERROR;
                                        else :
                                            foreach ($finalizados as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"]; ?></b> foi finalizado em <?php echo $contrt["timefinalizacaocontrato"]; ?>. Agora você pode avaliá-lo pelo serviço!</h7>
                                                        <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                        <div class="accordion-buttons my-2 d-flex gap-2">
                                                   
                                                    </div>

                                                    <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                </div>

                                        <?php
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
                        $solicitacoesRecebidas = $usuarioClass->selectContratosProfissional($idUser, 1);
                        $emAndamento = $usuarioClass->selectContratosProfissional($idUser, 2);
                        $finalizados = $usuarioClass->selectContratosProfissional($idUser, 3);
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
                                        echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhuma solicitação de contratação pendente.<span></div>
                                        ERROR;
                                    else :
                                        foreach ($solicitacoesRecebidas as $contrt) :
                                    ?>

                                            <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                <div class="clickable-image">
                                                    <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                    <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                </div>
                                                <div class="text">
                                                    <h7 class="m-0"><b><?php echo $contrt["nomeuser"] ?></b> quer te contratar como <?php echo ucfirst($contrt["descrespec"]); ?>!</h7>
                                                    <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                    <!-- FIXME - Não tá funfando -->
                                                    <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                    <div class="accordion-buttons my-2 d-flex gap-2">
                                                        <button class="btn btn-green" onclick="aceitarContrato(event)">Aceitar</button>
                                                        <button class="btn btn-outline-dark" onclick="recusarContrato(event)">Recusar</button>
                                                    </div>
                                                </div>

                                                <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                            </div>

                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <!-- !SECTION - Solicitações -->

                            <!-- SECTION - Em andamento -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emAndamentoContratado" data-bs-parent="#contratado-pane" aria-expanded="false" aria-controls="emAndamentoContratado">
                                        Contratos em andamento
                                    </button>
                                </h2>
                                <div id="emAndamentoContratado" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contratado-pane">
                                    <div>
                                        <?php
                                        if (empty($emAndamento)) :
                                            echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span></div>
                                        ERROR;
                                        else :
                                            foreach ($emAndamento as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"] ?></b> está em andamento! <br>Faça o serviço combinado para ganhar uma boa avaliação no final.</h7>
                                                        <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                        <div class="accordion-buttons my-2 d-flex gap-2">
                                                            <button onclick="solicitarFimContrato(event)" class="btn btn-green">O contrato foi realizado!</button>
                                                        </div>
                                                    </div>

                                                    <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                </div>

                                        <?php
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
                                        if (empty($finalizados)) :
                                            echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span></div>
                                        ERROR;
                                        else :
                                            foreach ($finalizados as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"]; ?></b> foi finalizado em <?php echo $contrt["timefinalizacaocontrato"]; ?>. Agora você pode avaliá-lo pelo serviço!</h7>
                                                        <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>
                                                    </div>

                                                    <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                </div>

                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION - Finalizados -->
                        </div>
                        <!-- !SECTION - Profissional -->

                        <!-- SECTION Agenda  -->
                        <div class="agenda my-5">
                            <h2>Agenda</h2>
                            <h6 class="text-muted">Veja quais são seus próximos compromissos</h6>
                            <!-- SECTION - Calendário -->
                            <div id="calendar" class="my-4"></div>
                            <!-- !SECTION - Calendário -->
                        </div>
                        <!-- !SECTION Agenda -->
                    </div>
                </div>
            </div>
    </main>

    <!-- Add jQuery library (required) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <!-- Add the evo-calendar.js for.. obviously, functionality! -->
    <script src="js/plugin/evoCalendar.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    // Initialize evo-calendar in your script file or an inline <script> tag
    $(document).ready(function() {
        $('#calendar').evoCalendar({
            'language': 'pt'
        })
    })
</script>

</html>