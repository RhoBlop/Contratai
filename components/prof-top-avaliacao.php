<div class="container align-items-center mb-5 hidden">
    <div class="mb-4">
        <h2>Categorias mais bem avaliadas</h2>
        <h6 class="text-muted">Veja quais são as categorias com médias de avaliações mais altas</h6>
    </div>
    <!-- CAROUSEL -->
    <div id="topAval" class="container carousel multitem-car">
        <div class="carousel-inner">
        <?php 
            $profissaoClass = new Profissao();
            $profsAv = $profissaoClass->selectMaiorAvaliacao($limit = 6);
            
            foreach ($profsAv as $prof): 
                [$idprof, $descrprof, $numAv, $mediaAv, $imgProf] = [$prof["idprof"], $prof["descrprof"], $prof["numavaliacao"], $prof["mediaavaliacao"], $prof["imgprof"]];

        ?>

        

            <!-- CARD PROFISSÃO -->
            <div class="carousel-item">
                <div class="card card-categoria rounded-3 shadow-sm">
                    <img src="<?php echoProfissaoImage($imgProf) ?>" class="card-img-top">
                    <div class="badge-avaliacao px-2 <?php echo echoAvaliacaoClass($mediaAv) ?>">
                        <!-- STAR ICON -->
                        <ion-icon name="star"></ion-icon>
                        <?php echo $mediaAv; ?>
                    </div>
                    <div class="card-body">
                        <h4><?php echo ucfirst($descrprof); ?></h4>
                        <p class="mb-2"><?php echo $numAv; ?> avaliações de contratantes</p>
                        <a href="<?php echo "profissao.php?id={$idprof}" ?>" class="btn btn-outline-green">Ver mais</a>
                        <a href="<?php echo "profissao.php?id={$idprof}" ?>"><span class="clickable-card"></span></a>
                    </div>
                </div>
            </div> <!-- /CARD PROFISSÃO -->
        
        <?php
            endforeach;
        ?>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#topAval" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#topAval" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div> <!-- /CAROUSEL -->
</div>