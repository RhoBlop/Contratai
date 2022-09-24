<div class="container align-items-center mb-5">
    <div class="mb-4">
        <h2>Maiores categorias</h2>
        <h6 class="text-muted">Veja quais são as categorias com mais usuários cadastrados</h6>
    </div>
    <!-- FUTURE SLIDER -->
    <div class="row g-5">
        <?php 
            $profClass = new Profissao();
            $profsPrincip = $profClass->selectMaisCadastros(3);
            
            foreach ($profsPrincip as $prof): 
                [$idprof, $dscprof, $numusr, $mediaAv] = [$prof["idprof"], $prof["dscprof"], $prof["numusr"], $prof["mediaavaliacao"]];
        ?>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-categoria rounded-3 shadow-sm">
                    <img src="images/temp/placeholder-card.jpg" class="card-img-top" style="object-fit: cover" height="200px">
                    <div class="badge-avaliacao px-2 <?php echo $mediaAv > 4 ? "avaliacao-otima" : "avaliacao-media" ?>">
                        <!-- STAR ICON -->
                        <ion-icon name="star"></ion-icon>
                        <?php echo $mediaAv; ?>
                    </div>
                    <div class="card-body">
                        <h4><?php echo ucfirst($dscprof); ?></h4>
                        <p><?php echo $numusr; ?> anúncios de usuários</p>
                        <a href="<?php echo "profissao.php?id={$idprof}" ?>" class="btn btn-outline-dark">Ver mais</a>
                    </div>
                </div>
            </div>
            
        <?php
            endforeach;
        ?>
    </div> <!-- /FUTURE SLIDER -->
</div>