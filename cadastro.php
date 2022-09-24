<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
        <script src="js/confirmaSenha.js"></script>
    </head>

    <body>
        <main>
            <div class="container-fluid">
                <div class="form-row row">
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                        <!-- LOGO -->
                        <a class="cadastro-logo" href="index.php">
                            <img src="images/logo/blue-logo.svg" alt="Logo" height="70px">
                        </a>
                        
                        <!-- Título Formulário -->
                        <div class="form-title d-flex flex-column mb-5">
                            <h2>Crie sua conta!</h2>
                            <h6>Preencha suas informações</h6>
                        </div>
                        
                        <form id="cadastro" class="form-cadastro d-flex flex-column" onsubmit="sendCadastro(event, '#feedbackUsuario')">

                            <!-- NOME -->
                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" autocomplete="off" required>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                            </div>

                            <!-- SENHA -->
                            <div class="form-group mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" autocomplete="off" required>
                            </div>

                            <!-- CONFIRMAÇÃO SENHA -->
                            <div class="form-group mb-1">
                                <label for="nome" class="form-label">Confirme sua senha</label>
                                <input type="password" class="form-control" id="confirmSenha" name="confirmSenha" onchange="confirmaSenha(event, '#senha', '#senhaErrada')" placeholder="Digite sua senha" autocomplete="off" required>
                                <small class="formMsgErro">As senhas precisam ser iguais</small>
                            </div>

                            <a class="ms-auto mb-2">Esqueci minha senha</a>

                            <!-- div para comunicação com usuário -->
                            <div id="feedbackUsuario"></div>

                            <button type="submit" class="btn btn-green mt-4">Cadastrar</button>
                        </form>
                    </div>

                    <div class="cadastro-side-image col-md-6"></div>
                </div>
            </div>
        </main>
    </body>
</html>