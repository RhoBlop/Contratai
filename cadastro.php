<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
        <script src="js/confirmaSenha.js"></script>
    </head>

    <body>
        <main>
            <div class="container-fluid">
                <a class="cadastro-logo" href="index.php">
                    <img src="images/logo/favicon.svg" alt="Logo" height="48px">
                </a>
                <div class="form-row row">
                    
                    <div class="col-md-6 d-flex flex-column justify-content-start align-items-center my-5">
                    
                        <!-- Título Formulário -->
                        <div class="form-title my-3">
                            <h2>Crie sua conta!</h2>
                        </div>
                        
                        <form id="cadastro" class="form-cadastro row g-3" onsubmit="sendCadastro(event, '#feedbackUsuario')">
                                <!-- NOME -->
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control form-control-lg" id="nome" name="nome" placeholder="Digite seu nome" autocomplete="off" required>
                                </div>

                                <!-- EMAIL -->
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Digite seu email" required>
                                </div>

                                <!-- CPF -->
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control form-control-lg" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
                                </div>

                                <!-- CPF -->
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
                                </div>

                                <!-- SENHA -->
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control form-control-lg" id="senha" name="senha" placeholder="Digite sua senha" autocomplete="off" required>
                                </div>

                                <!-- CONFIRMAÇÃO SENHA -->
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control form-control-lg" id="confirmSenha" name="confirmSenha" onchange="confirmaSenha(event, '#senha', '#senhaErrada')" placeholder="Digite sua senha" autocomplete="off" required>
                                    <small class="formMsgErro">As senhas precisam ser iguais</small>
                                </div>

                                <!-- div para comunicação com usuário -->
                                <div id="feedbackUsuario" class="collapse"></div>

                            <!-- BOTÕES AÇÃO -->
                            <div class="buttons d-flex justify-content-end align-items-center gap-3 my-3">
                                    <a href="#" class="btn btn-link">Já sou usuário</a>
                                    <button type="submit" class="btn btn-green">Cadastrar</button>
                            </div>
                        </form>
                    </div>

                    <div class="cadastro-side-image col-md-6 px-0"><img src="images\teste2.jpg" alt=""></div>
            </div>
        </main>
    </body>
</html>