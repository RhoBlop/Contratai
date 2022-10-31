<div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="modal-title w-100">Entrar</h2>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="login" class="form-login d-flex flex-column" onsubmit="sendLogin(event)">
        <div class="modal-body mx-0">
              <!-- EMAIL -->
              <div class="form-group mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
              </div>
  
              <!-- SENHA -->
              <div class="form group mb-3">
                  <label for="password" class="form-label">Senha</label>
                  <input type="password" class="form-control" id="password" name="senha" placeholder="Digite sua senha" required>
                </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario"></div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="submit" class="btn btn-outline-green">Entrar</button>
        </div>
      </form>
    </div>
  </div>
</div>