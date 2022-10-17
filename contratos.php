<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("components/head.php") ?>
    <script src="js/fetch/statusContratos.js"></script>
</head>

<body>
    <?php include("components/auth-header.php") ?>

    <main>
        <div class="container p-3 my-3">
            <div class="row gx-5">

                <?php include("components/sidebar.php") ?>

                <div class="col-7 px-3 d-flex flex-column" id="settingsContent">
                    <div class="mb-4">
                        <h2>Meus contratos</h2>
                        <h6 class="text-muted">Aceite solicitações de contratos, visualize os que estão em andamento e finalize-os</h6>
                    </div>

                    <div class="nav nav-justified filter-tablist rounded-3 mb-3" id="tablist" role="tablist">
                        <a class="nav-link active" id="contratante-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratante-pane" role="tab">Contratei</a>
                        <a class="nav-link" id="contratado-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratado-pane" role="tab">Contratado</a>
                    </div>



                    <div class="tab-content">

                        <!-- ========================= 
                                        CONTRATANTE
                                 ========================= -->
                        <?php
                        require("php/database/Contrato.php");
                        $contrato = new Contrato();
                        $idUser = $_SESSION["iduser"];

                        $solicitacoesRecebidas = $contrato->selectContratosContratante($idUser, 1);
                        $emAndamento = $contrato->selectContratosContratante($idUser, 2);
                        $finalizados = $contrato->selectContratosContratante($idUser, 3);
                        ?>

                        <div class="accordion accordion-flush tab-pane fade show active" id="contratante-pane" role="tabpanel">

                            <!-- SOLICITAÇÕES -->
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
                                            <div class="empty-accordion d-flex justify-content-center">Nenhum contrato por aqui.</div>
                                        ERROR;
                                        else :
                                            foreach ($solicitacoesRecebidas as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start justify-content-between" data-contratoid="<?php echo $contrt["idcontrato"]; ?>">
                                                    <div class="d-flex gap-3">
                                                        <img id="accordionProfilePic" src="<?php echoProfileImage($contrt["imguser"]); ?>" height="64px" width="64px">
                                                        <div class="text">
                                                            <h8>Você enviou uma solicitação para <b><?php echo $contrt["nomeuser"] ?></b>!</h8>
                                                            <p class="text-muted">Profissão: <?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                            <p class="text-muted">Dias agendados:</p>
                                                            <div class="contract-dates my-1">
                                                                <div class="date-chip">
                                                                    13 de set.
                                                                </div>
                                                                <div class="date-chip outline">
                                                                    13 de set.
                                                                </div>
                                                            </div>
                                                            <p class="text-muted">Aguarde o usuário aceitar ou rejeitar seu pedido</p>
                                                        </div>

                                                    <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                    <!-- <a href="<?php /* echo "perfil-publico.php?id={$contrt['iduser']}"; */?>" class="stretched-link"></a> O
                                                    O LINK TA BUGANDO A BOX, PQ ELE TA CONTANDO COMO UM FLEX ITEM...
                                                    DAI EU TIREI ELE POR ENQUANTO 
                                                    -->
                                                </div>

                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- EM ANDAMENTO -->
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
                                                <div class="empty-accordion d-flex justify-content-center">Nenhum contrato por aqui.</div>
                                            ERROR;
                                        else :
                                            foreach ($emAndamento as $contrt) :
                                        ?>

                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- FINALIZADOS -->
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
                                                <div class="empty-accordion d-flex justify-content-center">Nenhum contrato por aqui.</div>
                                            ERROR;
                                        else :
                                            foreach ($finalizados as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <img id="profile-pic" src="<?php echoProfileImage($contrt["imguser"]); ?>" width="52px">
                                                    <div class="text">
                                                        <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"]; ?></b> foi finalizado em <?php echo $contrt["timefinalizacaocontrato"]; ?>. Agora você pode avaliá-lo pelo serviço!</h7>
                                                        <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                        <div class="accordion-buttons d-flex gap-2">
                                                            <button class="btn btn-green">Avaliar o contrato</button>
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
                        </div>
                        <!-- ========================= 
                                        CONTRATANTE
                                 ========================= -->


                        <!-- ========================= 
                                        CONTRATADO
                                 ========================= -->
                        <?php
                        $solicitacoesRecebidas = $contrato->selectContratosProfissional($idUser, 1);
                        $emAndamento = $contrato->selectContratosProfissional($idUser, 2);
                        $finalizados = $contrato->selectContratosProfissional($idUser, 3);
                        ?>

                        <div class="accordion accordion-flush tab-pane fade" id="contratado-pane" role="tabpanel">

                            <!-- SOLICITAÇÕES -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#solicitacoesContratado" aria-expanded="true" aria-controls="solicitacoesContratado">
                                        Solicitações de contrato recebidas
                                    </button>
                                </h2>
                                <div id="solicitacoesContratado" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contratado-pane">
                                    <div>
                                        <?php
                                        if (empty($solicitacoesRecebidas)) :
                                            echo <<<ERROR
                                                <div class="empty-accordion d-flex justify-content-center">Nenhum contrato por aqui.</div>
                                            ERROR;
                                        else :
                                            foreach ($solicitacoesRecebidas as $contrt) :
                                        ?>

                                                <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                    <img id="profile-pic" src="<?php echoProfileImage($contrt["imguser"]); ?>" width="52px">
                                                    <div class="text">
                                                        <h7 class="m-0"><b><?php echo $contrt["nomeuser"] ?></b> quer te contratar como <?php echo ucfirst($contrt["descrespec"]); ?>!</h7>
                                                        <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                        <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                        <div class="accordion-buttons d-flex gap-2">
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

                                <!-- EM ANDAMENTO -->
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
                                                <div class="empty-accordion d-flex justify-content-center">Nenhum contrato por aqui.</div>
                                            ERROR;
                                            else :
                                                foreach ($emAndamento as $contrt) :
                                            ?>

                                                    <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                        <img id="profile-pic" src="<?php echoProfileImage($contrt["imguser"]); ?>" width="52px">
                                                        <div class="text">
                                                            <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"] ?></b> está em andamento! Faça o serviço combinado para ganhar uma boa avaliação no final.</h7>
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

                                <!-- FINALIZADO -->
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
                                                <div class="empty-accordion d-flex justify-content-center">Nenhum contrato por aqui.</div>
                                            ERROR;
                                            else :
                                                foreach ($finalizados as $contrt) :
                                            ?>

                                                    <div class="item-contrato accordion-body d-flex align-items-start gap-3" data-contratoid=<?php echo $contrt["idcontrato"]; ?>>
                                                        <img id="profile-pic" src="<?php echoProfileImage($contrt["imguser"]); ?>" width="52px">
                                                        <div class="text">
                                                            <h7 class="m-0">O contrato com <b><?php echo $contrt["nomeuser"]; ?></b> foi finalizado em <?php echo $contrt["timefinalizacaocontrato"]; ?>. Agora você pode avaliá-lo pelo serviço!</h7>
                                                            <p class="text-muted"><?php echo ucfirst($contrt["descrespec"]); ?></p>
                                                            <p class="text-muted"><?php echo time_elapsed_string($contrt["timecriacaocontrato"]); ?></p>

                                                            <div class="accordion-buttons d-flex gap-2">
                                                                <button class="btn btn-green">Avaliar o contrato</button>
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
                            </div>
                            <!-- ========================= 
                                        CONTRATADO
                                 ========================= -->

                        </div>
                    </div>
                </div>
            </div>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</html>