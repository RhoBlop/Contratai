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