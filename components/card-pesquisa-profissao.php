<div class="card card-hover card-pesquisa">
    <div class="search-profile-pic px-3">
        <img src="<?php echo echoProfileImage($imguser) ?>" alt="Imagem de perfil">
    </div>
    <div class="card-body">
        <div class="card-title d-flex justify-content-between align-items-center">
            <h5><?php echo $nomeuser; ?></h5>
            <span class="badge-avaliacao <?php echo echoAvaliacaoClass($mediaAv); ?>">
                <!-- STAR ICON -->
                <ion-icon name="star"></ion-icon>
                <?php echo $mediaAv; ?>
            </span>
        </div>
        <div class="card-text">
            <p>Total de <?php echo $numcontrato; ?> contratações como <?php echo ucfirst($descrprof); ?></p>

            <p>Em nossa plataforma desde <?php echo echoFullDate($datacriacaouser); ?></p>

            <a href="<?php echo "perfil-publico.php?id={$iduser}" ?>"><span class="clickable-card"></span></a>
        </div>
    </div>
</div>