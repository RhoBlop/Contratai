<!DOCTYPE html>
<html lang="pt-BR">
    <?php 
        if (!isset($_GET["id"])) {
            header("Location: 500.php");
        }
    ?>
    <head>
        <?php include ("components/head.php") ?>
    </head>
    <body>
    <!-- HOME PAGE HEADER -->
        <?php include ("components/login-header.php") ?>

        <?php 
            $userId = $_GET["id"];
            $perfPublico = $usuarioClass->selectPerfilPublicoById($userId);

            if (!$perfPublico)
                ?>

                <?php

            $especializacoes = $usuarioClass->selectEspecsById($userId);
            $avaliacoes = $usuarioClass->selectAvalById($userId);
            

            $perfEspecs = [];
            foreach($especializacoes as $espec) {
                $perfEspecs[] = $espec["dscespec"];
            }

            [$perfNomUsr, $perfBiografiaUsr, $perfNumContrato, $perfMediaAval, $perfImgUsr] = [$perfPublico["nomusr"], $perfPublico["biografiausr"], $perfPublico['numcontrato'], $perfPublico["mediaavaliacao"], $perfPublico["imgusr"]];
        ?>

        <main>
            <div class="container my-3">
                <div class="row gx-5">
                    <div class="col-12 col-lg-8" id="profile">

                        <!-- APRESENTAÇÃO PERFIL -->
                        <div class="card shadow-sm rounded-4 mb-3" id="infos">
                            <div class="header-card rounded-4  rounded-bottom">
                            </div>
                            <div class="card-body p-3 text-start">
                                <div class="top-body p-3 mb-1">
                                    <div class="profile-pic">
                                        <img src="<?php echoProfileImage($perfImgUsr)?>" class="rounded-circle" alt="">
                                    </div>
                                </div>

                                <div class="text px-3">
                                    <h3><?php echoDadosPerfil($perfNomUsr); ?></h3>
                                    <div class="body-text">
                                        <p><i class="fa-solid fa-briefcase fa-fw"></i><?php echo ucfirst(implode(", ", $perfEspecs)) ?></p>
                                        <p><i class="fa-solid fa-location-dot fa-fw"></i>[Desenvolvimento no futuro]</p>
                                        <p><i class="fa-solid fa-star fa-fw"></i><?php echoDadosPerfil($perfMediaAval); ?></p>
                                        <p><?php echo is_null($perfNumContrato) ? "Ainda não foi contratado nenhuma vez" : "{$perfNumContrato} trabalhos realizados"; ?></p>
                                        <a href="#avaliacao">[Desenvolvimento]</a><br>
                                    </div>
                                    <a href="#" class="btn btn-outline-green mt-3">Contactar</a>
                                </div>

                            </div>
                        </div> <!-- /APRESENTAÇÃO PERFIL -->

                        <!-- BIOGRAFIA -->
                        <div class="card shadow-sm rounded-4 mb-3" id="sobre">
                            <div class="card-body">
                                <h3 class="card-title">Sobre</h3>
                                <p><?php echoDadosBreakLine($perfBiografiaUsr); ?></p>
                            </div>
                        </div> <!-- /BIOGRAFIA -->

                        <!-- ESPECIALIZAÇÕES -->
                        <div class="card shadow-sm rounded-4 mb-3" id="sobre">
                            <div class="card-body">
                                <h3 class="card-title">Especializações</h3>
                                <?php
                                    foreach($especializacoes as $espec):
                                        [$dscEspec, $mediaEspec] = [$espec["dscespec"], $espec["mediaavaliacao"]]
                                ?>

                                    <div class="card card-hover card-pesquisa">
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h5><?php echo ucfirst($dscEspec); ?></h5>
                                                <span class="badge-avaliacao <?php echo echoAvaliacaoClass($mediaEspec); ?>">
                                                    <!-- STAR ICON -->
                                                    <ion-icon name="star"></ion-icon>
                                                    <?php echoDadosPerfil($mediaEspec); ?>
                                                </span>
                                            </div>
                                            <div class="card-text">
                                                <p>[SQL não tá funcionando como esperado] <?php echo is_null($perfPublico["numcontrato"]) ? "Ainda não foi contratado nenhuma vez" : "{$perfNumContrato} trabalhos realizados"; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                <?php 
                                    endforeach;
                                ?>
                            </div>
                        </div> <!-- /ESPECIALIZAÇÕES -->

                        <!-- AVALIAÇÕES -->
                        <div class="card shadow-sm rounded-4 mb-3 d-flex" id="avaliacao">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h3 class="card-title mb-3">Avaliações</h3>

                                <div class="subtitle d-flex gap-1 mb-3">
                                <i class="fa-solid fa-star fa-fw"></i>
                                    <h4 class="mb-3">4.5 de 50 Avaliações</h4>
                                </div>

                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    <?php
                                        foreach ($avaliacoes as $aval):
                                    ?>
                                
                                        <div class="avaliacao col mb-3">
                                            <div class="avaliacao-header d-flex align-items-start gap-3 mb-3">
                                                <div class="aval-pic">
                                                    <img src="<?php echoProfileImage($aval["imgusr"]); ?>" class="rounded-circle">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h5 class="mb-0"><?php echo $aval["nomusr"]; ?></h5>
                                                    <p class="text-muted">[atualizar banco]</p>
                                                </div>
                                            </div>

                                            <p><?php echo ucfirst($aval["comentarioavaliacao"]); ?></p>
                                        </div>

                                    <?php 
                                        endforeach;
                                    ?>
                                </div>

                            </div>
                        </div> <!-- /AVALIAÇÕES -->

                    </div>


                    <!--
                    <div class="col-4">

                        <div class="row mb-5" id="fotos">
                            <h3>Galeria</h3>

                            <div class="col-10 p-0">
                                <div class="big-photo">
                                    <img src="images\temp\eletricista.png" alt="">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row g-2">
                                    <div class="sm-photo">
                                        <img src="images\temp\eletricista.png" alt="">
                                    </div>
                                    <div class="sm-photo">
                                        <img src="images\temp\eletricista.png" alt="">
                                    </div>
                                    <div class="sm-photo">
                                        <img src="images\temp\eletricista.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    -->

                    </div>

                </div>
            </div>
        </main>


        <!-- FOOTER -->
        <?php include ("components/footer.html") ?>

        <!-- JS BOOTSTRAP BUNDLE -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"
        ></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>
