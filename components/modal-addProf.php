
<div class="modal fade" id="modal-addProf" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100">Adicionar profissão</h5>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="login" class="form-login d-flex flex-column" onsubmit="sendLogin(event)">
        <div class="modal-body mx-0">
              <!-- PROFISSAO -->
              <div class="form-group mb-3">
                <label for="profissao" class="form-label">Profissão</label>
                <select class="form-select form-select-lg" id="profissao" aria-label="profissao">
                  <option selected disabled>Selecione sua profissão</option>
                  <option value="1">KK</option>
                  <option value="2">Se</option>
                  <option value="3">Vira</option>
                  <option value="4">Pra</option>
                  <option value="5">Colocar</option>
                  <option value="6">Sua</option>
                  <option value="7">Profissão</option>
                </select>
              </div>
  
              <!-- ESPECIALIZAÇÃO -->
              <div class="form-group mb-3">
                <label for="especializacao" class="form-label">Especialização</label>
                <select class="form-select form-select-lg" id="especializacao" aria-label="especializacao">
                  <option selected disabled>Selecione sua Especialização</option>
                  <option value="1">KK</option>
                  <option value="2">Se</option>
                  <option value="3">Vira</option>
                  <option value="4">Pra</option>
                  <option value="5">Colocar</option>
                  <option value="6">Sua</option>
                  <option value="7">Especialização</option>
                </select>
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