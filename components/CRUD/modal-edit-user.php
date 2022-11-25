<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100">Adicione sua profissão!</h5>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

        <div id="modalBody" class="modal-body mx-0">
            <form id="updateUser" onsubmit="sendUpdate(event)">
                <label id="inputFileLabel" for="inputImg" class="rounded-circle mb-4">
                    <img src="<?php echoProfileImage($user["imguser"]) ?>" id="imgPerfil" alt="">
                    <div class="editar-hover">
                        <i class="fa-solid fa-pen"></i>
                        <p>Editar Foto</p>
                    </div>
                </label>
                <input id="inputImg" type="file" name="imgPerfil" onchange="showSelectedImg(event, '#imgPerfil')">

                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required value="<?php echoDadosNotNull($user["nomeuser"], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echoDadosNotNull($user["emailuser"], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" placeholder="" disabled value="<?php echoDadosNotNull($user["cpfuser"], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echoDadosNotNull($user["telefoneuser"], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="nascimento" name="nascimento" value="<?php echoDadosNotNull($user["nascimentouser"], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="5" style="white-space: pre-wrap;"><?php echoDadosNotNull($user["biografiauser"], null) ?></textarea>
                </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario"></div>
                
                <div class="buttons d-flex justify-content-end align-items-center py-3">
                    <a href="perfil.php" class="btn btn-link me-3">Cancelar</a>
                    <button type="submit" class="btn btn-outline-green">Salvar Alterações</button>
                </div>
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button id="addEspecBtn" class="btn btn-outline-green"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
  </div>
</div>