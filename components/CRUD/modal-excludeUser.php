<div class="modal fade" id="<?php echo 'modalExclude'. $user['iduser']?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header text-center">
        <h3 class="modal-title w-100" id="modalExclude">Aviso</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
        <p>Você está prestes a excluir esta conta permanentemente.</p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="deleteUserById(<?php echo $user['iduser']?>)">Excluir</button>
        </div>
    </div>
    </div>
</div>