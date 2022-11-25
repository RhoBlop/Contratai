<?php session_start() ?>
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
                                case 3:
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
                                            echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhuma solicitação de contratação pendente.</span></div>
                                        ERROR;
                                        else :
                                            foreach ($solicitacoesEnviadas as $contrt) :
                                        ?> 

                                                <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid="<?php echo $contrt["idcontrato"]; ?>">
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
                                                                        if (isDateExpired($diacontrato)) {
                                                                            $class = " expired";
                                                                        } else {
                                                                            $class = "";
                                                                        }
                                                                        echo "<div class='date-chip{$class}'>";
                                                                        echoMediumDate($diacontrato);
                                                                        echo '</div>';
                                                                    }
                                                                ?>
                                                            </div>
                                                            <p>Aguarde o usuário aceitar ou rejeitar seu pedido</p>
                                                        </div>
                                                    </div>
                                                    <div class="time text-end">
                                                        <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
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
                                        if (empty($emAndamentoEnviados)) :
                                            echo <<<ERROR
                                                <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span></div>
                                            ERROR;
                                        else :
                                            foreach ($emAndamentoEnviados as $contrt) :
                                        ?>

                                                <?php
                                                    if ($contrt["idstatus"] === 2):
                                                ?> 

                                                    <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid="<?php echo $contrt["idcontrato"]; ?>">
                                                        <div class="d-flex gap-3">
                                                            <div class="clickable-image">
                                                                <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                                <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                            </div>
                                                            <div class="text">
                                                                <h8>O contrato com <b><?php echo $contrt["nomeuser"] ?></b> está em andamento.</h8>

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

                                                                <p>Após o usuário contratado finalizar o contrato você poderá avaliá-lo!</p>
                                                            </div>
                                                        </div>

                                                        <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                    </div>

                                                <?php
                                                    elseif ($contrt["idstatus"] === 3):
                                                ?>

                                                    <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid="<?php echo $contrt["idcontrato"]; ?>">
                                                        <div class="d-flex gap-3">
                                                            <div class="clickable-image">
                                                                <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                                <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                            </div>
                                                            <div class="text">
                                                                <h8>O contratado <b><?php echo $contrt["nomeuser"] ?></b> solicitou o fim do contrato. Caso ele tenha cumprido o serviço oferecido, clique no botão abaixo.</h8>
                                                    
                                                                <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                                <p class="text-muted">Dias agendados:</p>
                                                                <div class="contract-dates my-1">
                                                                    <?php
                                                                        foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                            if (isDateExpired($diacontrato)) {
                                                                                $class = " expired";
                                                                            } else {
                                                                                $class = "";
                                                                            }
                                                                            echo "<div class='date-chip{$class}'>";
                                                                            echoMediumDate($diacontrato);
                                                                            echo '</div>';
                                                                        }
                                                                    ?>
                                                                </div>
                                                                
                                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                                    <button class="btn btn-outline-green" onclick="aceitarFimContrato(event)">O contrato foi realizado!</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                    </div>

                                                <?php
                                                    elseif ($contrt["idstatus"] === 5):
                                                ?>
                                                
                                                    <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid="<?php echo $contrt["idcontrato"]; ?>">
                                                        <div class="d-flex gap-3">
                                                            <div class="clickable-image">
                                                                <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                                <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                            </div>
                                                            <div class="text">
                                                                <h8>Infelizmente as datas do contrato com <b><?php echo $contrt["nomeuser"] ?></b> expiraram e o contrato não foi finalizado pelo contratado. Caso isso não tenha sido combinado entre os dois, você pode agora avaliá-lo.</h8>
                                                    
                                                                <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                                <p class="text-muted">Dias agendados:</p>
                                                                <div class="contract-dates my-1">
                                                                    <?php
                                                                        foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                            if (isDateExpired($diacontrato)) {
                                                                                $class = " expired";
                                                                            } else {
                                                                                $class = "";
                                                                            }
                                                                            echo "<div class='date-chip{$class}'>";
                                                                            echoMediumDate($diacontrato);
                                                                            echo '</div>';
                                                                        }
                                                                    ?>
                                                                </div>
                                                                
                                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                                    <?php
                                                                        if (!$contrt["isavaliado"]):
                                                                    ?>

                                                                        <button type="button" class="btn btn-green px-2" data-bs-toggle="modal" data-bs-target="#<?php echo "avaliacao{$contrt['idcontrato']}"; ?>">Avaliar</button>

                                                                    <?php
                                                                        else:
                                                                    ?>

                                                                        <p class="text-muted">Você já avaliou esse contrato.</p>

                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                    </div>

                                                    <!-- MODAL DE AVALIAÇÃO -->
                                                    <?php
                                                        include("components/modal-avaliacao.php");
                                                    ?>

                                                <?php
                                                    endif;
                                                ?>
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
                                        if (empty($finalizadosEnviados)) :
                                            echo <<<ERROR
                                                <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span>.</div>
                                            ERROR;
                                        else :
                                            foreach ($finalizadosEnviados as $contrt) :
                                        ?>

                                                <div class="id-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h8>O contrato com <b><?php echo $contrt["nomeuser"]; ?></b> foi finalizado em <?php echoFullDate($contrt["timefinalizacaocontrato"]); ?>. Agora você pode avaliá-lo pelo serviço!</h8>

                                                        <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted">Dias agendados:</p>
                                                        <div class="contract-dates my-1">
                                                            <?php
                                                                foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                    if (isDateExpired($diacontrato)) {
                                                                        $class = " expired";
                                                                    } else {
                                                                        $class = "";
                                                                    }
                                                                    echo "<div class='date-chip{$class}'>";
                                                                    echoMediumDate($diacontrato);
                                                                    echo '</div>';
                                                                }
                                                            ?>
                                                        </div>

                                                        <div class="contrato-buttons my-2 d-flex gap-2">
                                                            <?php
                                                                if (!$contrt["isavaliado"]):
                                                            ?>

                                                                <a type="button" class="btn btn-green px-2" data-bs-toggle="modal" data-bs-target="#<?php echo "avaliacao{$contrt['idcontrato']}"; ?>">Avaliar</a>

                                                            <?php
                                                                else:
                                                            ?>

                                                                <p class="text-muted">Você já avaliou esse contrato!</p>

                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                </div>

                                                <!-- MODAL DE AVALIAÇÃO -->
                                                <?php
                                                    include("components/modal-avaliacao.php");
                                                ?>

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
                                        echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhuma solicitação de contratação pendente.<span></div>
                                        ERROR;
                                    else :
                                        foreach ($solicitacoesRecebidas as $contrt) :
                                    ?>

                                            <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                <div class="d-flex gap-3">
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h8><b><?php echo $contrt["nomeuser"] ?></b> quer te contratar!</h8>
    
                                                        <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p>Dias agendados:</p>
                                                        <div class="contract-dates my-2">
                                                            <?php
                                                                foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                    if (isDateExpired($diacontrato)) {
                                                                        $class = " expired";
                                                                    } else {
                                                                        $class = "";
                                                                    }
                                                                    echo "<div class='date-chip{$class}'>";
                                                                    echoMediumDate($diacontrato);
                                                                    echo '</div>';
                                                                }
                                                            ?>
                                                        </div>
    
                                                        <div class="contrato-buttons my-3 d-flex gap-2">
                                                            <button class="btn btn-green" onclick="aceitarContrato(event)">Aceitar</button>
                                                            <button class="btn btn-outline-dark" onclick="recusarContrato(event)">Recusar</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
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
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emAndamentoContratado" aria-expanded="false" aria-controls="emAndamentoContratado">
                                        Contratos em andamento
                                    </button>
                                </h2>
                                <div id="emAndamentoContratado" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contratado-pane">
                                    <div>
                                        <?php
                                        if (empty($emAndamentoRecebidos)) :
                                            echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span></div>
                                        ERROR;
                                        else :
                                            foreach ($emAndamentoRecebidos as $contrt) :
                                        ?>

                                                <?php
                                                    if ($contrt["idstatus"] === 2): 
                                                ?>

                                                    <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                        <div class="d-flex gap-3">
                                                            <div class="clickable-image">
                                                                <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                                <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                            </div>
                                                            <div class="text">
                                                                <h8 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"] ?></b> está em andamento! Quando você terminar o serviço, clique no botão abaixo para solicitar o fim do contrato ao usuário.</h8>
                                                                
                                                                <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                                <p>Dias agendados:</p>
                                                                <div class="contract-dates my-2">
                                                                    <?php
                                                                        foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                            if (isDateExpired($diacontrato)) {
                                                                                $class = " expired";
                                                                            } else {
                                                                                $class = "";
                                                                            }
                                                                            echo "<div class='date-chip{$class}'>";
                                                                            echoMediumDate($diacontrato);
                                                                            echo '</div>';
                                                                        }
                                                                    ?>
                                                                </div>
    
                                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                                    <button onclick="solicitarFimContrato(event)" class="btn btn-outline-green">O contrato foi realizado!</button>
                                                                </div>
                                                            </div>
                                                            <div class="time text-end">
                                                                <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                            </div>
                                                        </div>
    
                                                    <?php
                                                        elseif ($contrt["idstatus"] === 3): 
                                                    ?>
    
                                                        <div class="id-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                            <div class="d-flex gap-3">
                                                                <div class="clickable-image">
                                                                    <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                                    <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                                </div>
                                                                <div class="text">
                                                                    <h8 class="m-0">Você enviou uma solicitação ao contratante <b><?php echo $contrt["nomeuser"] ?></b> para finalizar o contrato.</h8>
                                                                    
                                                                    <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                                    <p>Dias agendados:</p>
                                                                    <div class="contract-dates my-2">
                                                                        <?php
                                                                            foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                                if (isDateExpired($diacontrato)) {
                                                                                    $class = " expired";
                                                                                } else {
                                                                                    $class = "";
                                                                                }
                                                                                echo "<div class='date-chip{$class}'>";
                                                                                echoMediumDate($diacontrato);
                                                                                echo '</div>';
                                                                            }
                                                                        ?>
                                                                    </div>
        
                                                                    <p>Aguarde o contratante aceitar sua solicitação</p>
                                                                </div>

                                                            </div>
                                                            <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                        </div>
    
                                                    <?php
                                                        elseif ($contrt["idstatus"] === 5):
                                                    ?>
    
                                                        <div class="id-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                            <div class="clickable-image">
                                                                <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                                <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                            </div>
                                                            <div class="text">
                                                                <h8 class="m-0">Você não finalizou o contrato com <b><?php echo $contrt["nomeuser"] ?></b> dentro da data prevista. O usuário contratante pode agora avaliá-lo por seu serviço.</h8>
                                                                
                                                                <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                                <p>Dias agendados:</p>
                                                                <div class="contract-dates my-2">
                                                                    <?php
                                                                        foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                            if (isDateExpired($diacontrato)) {
                                                                                $class = " expired";
                                                                            } else {
                                                                                $class = "";
                                                                            }
                                                                            echo "<div class='date-chip{$class}'>";
                                                                            echoMediumDate($diacontrato);
                                                                            echo '</div>';
                                                                        }
                                                                    ?>
                                                                </div>
    
                                                                <div class="contrato-buttons my-2 d-flex gap-2">
                                                                    [Por enquanto não é possível realizar nenhuma ação enquanto o contrato está atrasado]
                                                                    <!-- <button onclick="solicitarFimContrato(event)" class="btn btn-green">O contrato foi realizado!</button> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="time text-end">
                                                            <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
                                                        </div>
                                                    </div>

                                                <?php
                                                    endif; 
                                                ?>

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
                                        if (empty($finalizadosRecebidos)) :
                                            echo <<<ERROR
                                            <div class="empty-accordion accordion-body"><span class="text-muted">Nenhum contrato por aqui.</span></div>
                                        ERROR;
                                        else :
                                            foreach ($finalizadosRecebidos as $contrt) :
                                        ?>

                                                <div class="id-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <div class="clickable-image">
                                                        <img src="<?php echoProfileImage($contrt["imguser"]); ?>">
                                                        <a href="<?php echo "perfil-publico.php?id={$contrt['iduser']}"; ?>" class="stretched-link"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"]; ?></b> foi finalizado com sucesso em <?php echoFullDate($contrt["timefinalizacaocontrato"]); ?>!</h7>
                                                        
                                                        <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p>Dias agendados:</p>
                                                        <div class="contract-dates my-2">
                                                            <?php
                                                                foreach ($contrt["diascontrato"] as $diacontrato) {
                                                                    if (isDateExpired($diacontrato)) {
                                                                        $class = " expired";
                                                                    } else {
                                                                        $class = "";
                                                                    }
                                                                    echo "<div class='date-chip{$class}'>";
                                                                    echoMediumDate($diacontrato);
                                                                    echo '</div>';
                                                                }
                                                            ?>
                                                        </div>

                                                        <div class="contrato-buttons my-2 d-flex gap-2">
                                                            <?php
                                                                if (!$contrt["isavaliado"]):
                                                            ?>

                                                                <p class="text-muted">O contrante pode agora avaliar o contrato!</p>

                                                            <?php
                                                                else:
                                                            ?>

                                                                <p class="text-muted">O contrato já foi avaliado!</p>
                                                                //TODO - Adicionar modal com a avaliação feita pelo usuário

                                                            <?php endif; ?>
                                                        </div>

                                                        
                                                    </div>

                                                    <p class="text-muted"><?php echo timeElapsedString($contrt["timecriacaocontrato"]); ?></p>
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