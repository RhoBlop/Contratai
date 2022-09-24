<div class="container align-items-center mb-5">
    <div class="mb-4">
        <h2>Categorias mais bem avaliadas</h2>
        <h6 class="text-muted">Veja quais são as categorias com médias de avaliações mais altas</h6>
    </div>
    <!-- FUTURE SLIDER -->
    <div class="row g-5">
        <?php 
            $profClass = new Profissao();
            $profsAv = $profClass->selectMaiorAvaliacao(3);
            
            foreach ($profsAv as $prof): 
                [$idprof, $dscprof, $numAv, $mediaAv] = [$prof["idprof"], $prof["dscprof"], $prof["numavaliacao"], $prof["mediaavaliacao"]];
        ?>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-categoria rounded-3 shadow-sm">
                    <img src="images/temp/placeholder-card.jpg" class="card-img-top" style="object-fit: cover" height="200px">
                    <div class="badge-avaliacao px-2 <?php echo $mediaAv > 4.5 ? "avaliacao-otima" : "avaliacao-media" ?>">
                        <!-- STAR ICON -->
                        <ion-icon name="star"></ion-icon>
                        <?php echo $mediaAv; ?>
                    </div>
                    <div class="card-body">
                        <h4><?php echo ucfirst($dscprof); ?></h4>
                        <p><?php echo $numAv; ?> avalições de contratantes</p>
                        <a href="<?php echo "profissao.php?id={$idprof}" ?>" class="btn btn-outline-dark">Ver mais</a>
                    </div>
                </div>
            </div>
            
        <?php
            endforeach;
        ?>
    </div> <!-- /FUTURE SLIDER -->
</div>