<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/auth-header.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">

                    <?php include("components/sidebar.php")?>

                    <div class="col-7 px-3" id="settingsContent">
                        <div class="mb-4">
                            <h2>Meus contratos</h2>
                            <h6 class="text-muted">Aceite pedidos de contratos, visualize os que estão em andamento e finalize-os</h6>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="filter-tablist mb-3" id="tablist" role="tablist">
                                <button class="nav-link active" id="contratante-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratante-pane" role="tab">Contratei</button>
                                <button class="nav-link" id="contratado-tab" data-bs-toggle="tab" type="button" data-bs-target="#contratado-pane" role="tab">Contratado</button>
                            </div>
                        </div>

                        <div class="tab-content">
    
                            <!-- ========================= 
                                        CONTRATANTE
                                 ========================= -->
                            <?php
                                require("php/database/Contrato.php");
                                $contrato = new Contrato();

                                $pedidosRecebidos = $contrato->selectPedidosProfissional();
                            ?>

                            <div class="accordion tab-pane fade show active" id="contratante-pane" role="tabpanel">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pedidos" aria-expanded="true" aria-controls="pedidos">
                                        Pedidos de contratação
                                    </button>
                                    </h2>
                                    <div id="pedidos" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contratos">
                                        <div class="accordion-body">
                                            [implement PHP]
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emAndamento" aria-expanded="false" aria-controls="emAndamento">
                                        Contratos em andamento
                                    </button>
                                    </h2>
                                    <div id="emAndamento" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contratos">
                                        <div class="accordion-body">
                                            [implement PHP]
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalizados" aria-expanded="false" aria-controls="finalizados">
                                        Contratos finalizados
                                    </button>
                                    </h2>
                                    <div id="finalizados" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#contratos">
                                        <div class="accordion-body">
                                            [implement PHP]
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
                            <div class="accordion tab-pane fade" id="contratado-pane" role="tabpanel">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pedidos" aria-expanded="true" aria-controls="pedidos">
                                        Teste1
                                    </button>
                                    </h2>
                                    <div id="pedidos" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contratos">
                                        <div class="accordion-body">
                                            [implement PHP]
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emAndamento" aria-expanded="false" aria-controls="emAndamento">
                                        Contratos em andamento
                                    </button>
                                    </h2>
                                    <div id="emAndamento" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contratos">
                                        <div class="accordion-body">
                                            [implement PHP]
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalizados" aria-expanded="false" aria-controls="finalizados">
                                        Contratos finalizados
                                    </button>
                                    </h2>
                                    <div id="finalizados" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#contratos">
                                        <div class="accordion-body">
                                            [implement PHP]
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>