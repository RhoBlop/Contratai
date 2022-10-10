<!DOCTYPE html>
<html lang="pt-BR">
    <?php 
        if (!isset($_GET["id"])) {
            header("Location: 500.php");
        }
    ?>
    <head>
        <?php include ("components/head.php") ?>
        <script src="js/profileAvalFilter.js"></script>
    </head>
    <body>
    <!-- HOME PAGE HEADER -->
        <?php include ("components/auth-header.php") ?>

        <?php 
            $usuarioClass = new Usuario();
            $userId = $_GET["id"];

            $perfPublico = $usuarioClass->selectPerfilPublicoById($userId);

            if (!$perfPublico):
                ?>
                    <div>
                        É necessário cadastrar uma profissão para que o perfil se torne público
                        <a href="">Finalizar cadastro</a>
                    </div>
                <?php
                exit();
            endif;

            $especializacoes = $usuarioClass->selectEspecsPerfPublicoById($userId);
            $avaliacoes = $usuarioClass->selectAvaliacoesById($userId);
            

            $perfEspecs = [];
            foreach($especializacoes as $espec) {
                $perfEspecs[] = $espec["dscespec"];
            }

            $numAval = count($avaliacoes);
            [$perfNomUsr, $perfBiografiaUsr, $perfNumContrato, $perfMediaAval, $perfImgUsr] = [$perfPublico["nomusr"], $perfPublico["biografiausr"], $perfPublico['numcontrato'], $perfPublico["mediaavaliacao"], $perfPublico["imgusr"]];
        ?>

        <main>
            <div class="container my-3">
                <div class="row gx-5 justify-content-center">
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
                                    <h3><?php echoDadosNotNull($perfNomUsr, "---"); ?></h3>
                                    <div class="body-text">
                                        <p><i class="fa-solid fa-briefcase fa-fw"></i><?php echo ucfirst(implode(", ", $perfEspecs)) ?></p>
                                        <p><i class="fa-solid fa-location-dot fa-fw"></i>[Desenvolvimento no futuro]</p>
                                        <p><i class="fa-solid fa-star fa-fw"></i><?php echoDadosNotNull($perfMediaAval, "---"); ?></p>
                                        <p><?php echo is_null($perfNumContrato) ? "Ainda não foi contratado nenhuma vez" : "{$perfNumContrato} trabalhos realizados"; ?></p>
                                        <a href="#avaliacao" class="text-decoration-none"><?php echoDadosNotNull("{$numAval} avaliações recebidas", "---"); ?></a><br>
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
                                <div class="d-flex flex-column align-items-center">
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
                                                        <?php echoDadosNotNull($mediaEspec, "---"); ?>
                                                    </span>
                                                </div>
                                                <div class="card-text">
                                                    <p>[ Não sei fazer o SQL ] <?php echo is_null($perfPublico["numcontrato"]) ? "Ainda não foi contratado nenhuma vez" : "{$perfNumContrato} trabalhos realizados"; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    <?php 
                                        endforeach;
                                    ?>
                                </div>
                            </div>
                        </div> <!-- /ESPECIALIZAÇÕES -->
                        
                        <?php
                            // display avaliações
                            if ($avaliacoes):
                        ?>
                            <!-- AVALIAÇÕES -->
                            <div class="card shadow-sm rounded-4 mb-3 d-flex" id="avaliacao">
                                <div class="card-header filters-group" style="display: block">
                                    <input type="radio" id="todos" class="search-filter" name="filterAval" value="todos" checked>
                                    <label for="todos">Todos</label>
                                    <?php 
                                        foreach ($especializacoes as $espec) {
                                            $especId = $espec["idespec"];
                                            $dscEspec = ucfirst($espec["dscespec"]);
                                            echo <<<ITEM
                                                <input type="radio" id="{$especId}" class="search-filter" name="filterAval" value="{$especId}">
                                                <label for="{$especId}">{$dscEspec}</label>
                                            ITEM;
                                        }
                                    ?>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h3 class="card-title mb-3">Avaliações</h3>

                                    <div class="subtitle d-flex gap-1 mb-3">
                                        <i class="fa-solid fa-star fa-fw"></i>
                                        <h4 id="notaAvaliacoes" class="mb-3"><?php echo "{$perfMediaAval} de {$numAval} avaliações" ?></h4>
                                    </div>

                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <?php
                                            foreach ($avaliacoes as $aval):
                                        ?>
                                    
                                            <div class="avaliacao col mb-3" data-especid="<?php echo $aval["idespec"]; ?>" data-nota=<?php echo $aval["notaavaliacao"]; ?>>
                                                <div class="avaliacao-header d-flex align-items-start gap-3 mb-3">
                                                    <div class="aval-pic">
                                                        <img src="<?php echoProfileImage($aval["imgusr"]); ?>" class="rounded-circle">
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <h5 class="mb-0"><?php echo $aval["nomusr"]; ?></h5>
                                                        <p class="text-muted">
                                                            <i class="fa-solid fa-star fa-fw"></i>
                                                            <?php echo $aval["notaavaliacao"] ?>
                                                        </p>
                                                        <p class="text-muted"><?php echo ucfirst($aval["dscespec"]) ?></p>
                                                        <p class="text-muted">data [atualizar banco]</p>
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
                        <?php
                            // display avaliações
                            endif;
                        ?>

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
