<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("components/head.html") ?>
        <script src="js/confirmaSenha.js"></script>

        <script>
            async function sendUpdateSenha(event) {
                event.preventDefault();

                let senhaNova = document.querySelector("#senhaNova").value;
                let confirmSenhaNova = document.querySelector("#confirmSenhaNova").value;

                if (senhaNova === confirmSenhaNova) {
                    // transforma os dados do formulário para o formato x-www-form-urlencoded
                    let formData = new URLSearchParams(new FormData(event.target)).toString();
    
                    loading();
                    
                    let response = await fetch("./API/user/updateSenha.php", {
                        method: "POST",
                        credentials: "same-origin",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: formData
                    });
                    let data = await response.text();
                    console.log(data);
    
                    let { erro } = data;
                    if (erro) {
                        formErro(erro);
                    }
                    
                    let { action } = data;
                    if (action) {
                        window.location.href = "perfil.php";
                    }
                }

            }
        </script>
    </head>
    <body>
        <?php include ("components/login-header.html") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    
                    <?php include("components/modal-exclude.html")?>

                    <?php include("components/sidebar.html")?>

                    <div class="col-8 px-3" id="profile-content">
                        <div class="mb-4">
                            <h2>Editar senha</h2>
                            <h6 class="text-muted">Altere a senha da sua conta</h6>
                        </div>
                        
                        
                        <form id="updateUser" onsubmit="sendUpdateSenha(event)">
                        
                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Senha Atual</label>
                                <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" placeholder="Digite sua senha atual" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="senhaNova" name="senhaNova" placeholder="Digite sua nova senha" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Confirme a nova senha</label>
                                <input type="password" class="form-control" id="confirmSenhaNova" name="confirmSenhaNova" onchange="confirmaSenha(event, '#senhaNova')" placeholder="Repita sua nova senha" required>
                                <div class="formMsgErro">As senhas precisam ser iguais</div>
                            </div>
                            
                            <!-- div para comunicação com usuário -->
                            <div id="feedbackUsuario"></div>
                            
                            <div class="buttons d-flex justify-content-end align-items-center py-3">
                                <a href="perfil.php" class="btn btn-link me-3">Cancelar</a>
                                <button type="submit" class="btn btn-outline-green">Salvar nova senha</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </main>

        <?php include ("components/footer.html")?>
    </body>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>