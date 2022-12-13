<div class="modal fade" id="<?php echo 'modalInfo'. $user['iduser']?>" tabindex="-1" aria-labelledby="<?php echo 'modalInfo'. $user['iduser']?>" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 text-center" id="modalTitle">Mais informações</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="updateUser-<?php echo $user['iduser']?>" onsubmit="sendUpdateAdmin(event, <?php echo $user['iduser']?>)">
                <?php 
                    $imgId = "imgPerfil-{$user['iduser']}";
                    $labelId = "inputImg-{$user['iduser']}";
                ?>
                <label id="inputFileLabel" for="<?php echo $labelId ?>" class="rounded-circle mb-4">
                    <img src="<?php echoProfileImage($user['imguser']) ?>" id="<?php echo $imgId ?>" alt="">
                    <div class="editar-hover">
                        <i class="fa-solid fa-pen"></i>
                        <p>Editar Foto</p>
                    </div>
                </label>
                <input id="<?php echo $labelId ?>" type="file" name="imgPerfil" onchange="showSelectedImg(event, '#<?php echo $imgId ?>')">

                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required value="<?php echoDadosNotNull($user['nomeuser'], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echoDadosNotNull($user['emailuser'], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" placeholder="" disabled value="<?php echoDadosNotNull($user['cpfuser'], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echoDadosNotNull($user['telefoneuser'], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="bairro" class="form-control" id="bairro" name="bairro" value="<?php echoDadosNotNull($user['descrbairro'], null) ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="cidade" class="form-control" id="cidade" name="cidade" value="<?php echoDadosNotNull($user['descrcidade'], null) ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="nascimento" name="nascimento" value="<?php echoDadosNotNull($user['nascimentouser'], null) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="5" style="white-space: pre-wrap;"><?php echoDadosNotNull($user['biografiauser'], null) ?></textarea>
                </div>

                <!-- div para comunicação com usuário -->
                <div id="feedbackUsuario-<?php echo $user['iduser']?>" class="feedbackUsuario"></div>
                
                <div class="buttons d-flex justify-content-end align-items-center py-3">
                    <a data-bs-dismiss="modal" class="btn btn-link me-3">Cancelar</a>
                    <button type="submit" class="btn btn-outline-green">Salvar Alterações</button>
                </div>
            </form>
        
        </div>
    </div>
</div>
</div>