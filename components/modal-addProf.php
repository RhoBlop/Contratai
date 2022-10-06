<div class="modal fade" id="modal-addProf" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100">Adicione sua profissão!</h5>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="login" class="form-login d-flex flex-column" autocomplete="off" onsubmit="sendLogin(event)">
        <div class="modal-body mx-0">
            
              <!-- ESPECIALIZAÇÃO -->
              <div class="form-group mb-3">
                <label for="especializacao" class="form-label">Especialização</label>
                <input type="text" class="form-control form-control-lg" placeholder="Digite sua especialização" 
                id="especializacao" name="especializacao" onkeyup="showResults(this.value)"/>
                <div id="resultado"></div>
              </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario"></div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="submit" class="btn btn-outline-green">Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>