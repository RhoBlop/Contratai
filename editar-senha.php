<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/header-auth.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    <?php include("components/sidebar.php")?>

                    <div class="col-8 px-4" id="settingsContent">
                        <div class="mb-4">
                            <h2>Editar senha</h2>
                            <h6 class="text-muted">Altere a senha da sua conta</h6>
                        </div>
                        
                        
                        <form id="updateUser" onsubmit="sendUpdateSenha(event)">
                        
                            <div class="form-group mb-3">
                                <label for="senhaAtual" class="form-label">Senha Atual</label>
                                <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" autocomplete="off" placeholder="Digite sua senha atual" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="senhaNova" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="senhaNova" name="senhaNova" autocomplete="off" onchange="confirmaSenha(event, '#confirmaSenhaNova', '#senhaErrada')" placeholder="Digite sua nova senha" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirmaSenhaNova" class="form-label">Confirme a nova senha</label>
                                <input type="password" class="form-control" id="confirmaSenhaNova" name="confirmaSenhaNova" autocomplete="off" onchange="confirmaSenha(event, '#senhaNova', '#senhaErrada')" placeholder="Repita sua nova senha" required>
                                
                                <small id="senhaErrada" class="formMsgErro">As senhas precisam ser iguais</small>
                            </div>
                            
                            <!-- div para comunica????o com usu??rio -->
                            <div id="feedbackUsuario" class="feedbackUsuario"></div>
                            
                            <div class="buttons d-flex justify-content-end align-items-center py-3">
                                <a href="perfil.php" class="btn btn-link me-3">Cancelar</a>
                                <button type="submit" class="btn btn-outline-green">Salvar nova senha</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </main>
    </body>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>