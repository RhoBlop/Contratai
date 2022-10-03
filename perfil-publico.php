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
            var_dump($perfPublico);
            // $especializacoes = $usuarioClass->selectEspecsUsr($userId);
            // $avaliacoes = $usuarioClass->selectAvalById($userId);

            [$perfNomUsr, $perfBiografiaUsr, $perfNumContrato, $perfMediaAval, $perfEspecs] = [$perfPublico["nomusr"], $perfPublico["biografiausr"], $perfPublico['numcontrato'], $perfPublico["mediaavaliacao"], $perfPublico["especsusr"]];

        ?>

        <main>
            <div class="container my-3">
                <div class="row gx-5">
                    <div class="col-8" id="profile">

                        <!-- APRESENTAÇÃO PERFIL -->
                        <div class="card shadow-sm rounded-4 mb-3" id="infos">
                            <div class="header-card rounded-4  rounded-bottom">
                            </div>
                            <div class="card-body p-3 text-start">
                                <div class="top-body p-3 mb-1">
                                    <div class="profile-pic"><img src="images\temp\default-pic.png"class="rounded-circle" alt=""></div>
                                </div>

                                <div class="text px-3">
                                    <h3><?php echoDadosPerfil($perfNomUsr); ?></h3>
                                    <p><i class="fa-solid fa-briefcase fa-fw"></i><?php echo ucfirst(implode(", ", $perfEspecs)) ?></p>
                                    <p><i class="fa-solid fa-location-dot fa-fw"></i>[Desenvolvimento no futuro]</p>
                                    <p><i class="fa-solid fa-star fa-fw"></i><?php echoDadosPerfil($perfPublico["mediaavaliacao"]); ?></p>
                                    <p><?php echo is_null($perfPublico["numcontrato"]) ? "Ainda não foi contratado nenhuma vez" : "{$perfNumContrato} trabalhos realizados"; ?></p>
                                    <a href="#avaliacao">50 Avaliações recebidas</a><br>
                                    <a href="#" class="btn btn-outline-green mt-3">Contactar</a>
                                </div>

                            </div>
                        </div> <!-- /APRESENTAÇÃO PERFIL -->

                        <!-- BIOGRAFIA -->
                        <div class="card shadow-sm rounded-4 mb-3" id="sobre">
                            <div class="card-body">
                                <h3 class="card-title">Sobre</h3>
                                <p><?php echoDadosPerfil($perfBiografiaUsr); ?></p>
                            </div>
                        </div> <!-- /BIOGRAFIA -->

                        <!-- ESPECIALIZAÇÕES -->
                        <div class="card shadow-sm rounded-4 mb-3" id="sobre">
                            <div class="card-body">
                                <h3 class="card-title">Especializações</h3>
                                <?php
                                    foreach($especializacoes as $espec):
                                ?>

                                    <div class="card card-hover card-pesquisa">
                                        <img src="<?php echo echoProfileImage($imgusr) ?>" alt="Imagem de perfil">
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h5><?php echo $nomusr; ?></h5>
                                                <span class="badge-avaliacao <?php echo echoAvaliacaoClass($mediaAv); ?>">
                                                    <!-- STAR ICON -->
                                                    <ion-icon name="star"></ion-icon>
                                                    <?php echo $mediaAv; ?>
                                                </span>
                                            </div>
                                            <div class="card-text">
                                                <p>Total de <?php echo $numcontrato; ?> contratações como <?php echo $dscprof ?></p>

                                                <p>Em nossa plataforma desde <?php echo "[atualizar banco de dados]" ?></p>

                                                <a href="<?php echo "perfil-publico.php?id={$idusr}" ?>"><span class="clickable-card"></span></a>
                                            </div>
                                        </div>
                                    </div>

                                <?php 
                                    endforeach;
                                ?>
                            </div>
                        </div> <!-- /ESPECIALIZAÇÕES -->


                        <!-- AVALIAÇÕES -->
                        <div class="card shadow-sm rounded-4 mb-3" id="avaliacao">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Avaliações</h3>

                                <div class="subtitle d-flex gap-1 mb-3">
                                <i class="fa-solid fa-star fa-fw"></i>
                                    <h4 class="mb-3">4.5 de 50 Avaliações</h4>
                                </div>

                                <div class="row g-3">
                                    <?php
                                        foreach ($avaliacoes as $aval):
                                    ?>
                                
                                        <div class="avaliacao col">
                                            <div class="avaliacao-header d-flex align-items-start gap-3 mb-3">
                                                <img src="<?php echoProfileImage($aval["imgusr"]); ?>" width="48px">
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
