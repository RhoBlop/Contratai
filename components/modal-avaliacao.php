<div class="modal fade" id="<?php echo "avaliacao{$contrt['idcontrato']}"; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-center shadow-sm">
          <h2 class="modal-title">Avaliar contrato</h2>
        </div>
  
        <form id="avaliacao" class="form-login d-flex flex-column text-center" onsubmit="sendAvaliacao(event)">
            <div class="modal-body mx-0">
                <div class="form-group mb-3 text-muted text-center">
                    Agora que o contrato foi realizado, está na hora de avaliar o serviço do usuário contratado!
                </div>

                <!-- ID CONTRATO -->
                <input type="hidden" name="contratoId" value="<?php echo $contrt["idcontrato"] ?>">

                <!-- NOTA DA AVALIAÇÃO -->
                <div class="form-group mb-3">
                    <label for="nota" class="form-label">Nota</label>
                    <input type="number" name="nota" min="0" max="5" step="0.1" id="nota">
                </div>
                
                <!-- DESCRIÇÃO -->
                <div class="form-group mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea class="form-control" id="comentario" name="comentario" rows="4" style="white-space: pre-wrap;"></textarea>
                </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario" class="collapse feedbackUsuario"></div>
  
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-green">Avaliar</button>
            </div>
        </form>
      </div>
    </div>
</div>
