<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("components/head.php") ?>
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

                    <form id="cadastro" class="form-cadastro row g-3 my-3" autocomplete="off" onsubmit="sendCadastro(event, '#feedbackUsuario')">
                        <div class="step">
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
                                <input type="text" class="form-control form-control-lg" id="cpf" name="cpf" placeholder="Digite seu CPF" required oninput="setMask(this, maskCPF)" maxlength="14">
                            </div>

                            <!-- TELEFONE -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" placeholder="Digite seu telefone" required oninput="setMask(this, maskTelefone)" maxlength="15">
                            </div>

                        </div>

                        <div class="step">
                            <!-- CEP -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-lg" id="cep" name="cep" placeholder="Digite seu cep" required oninput="setMask(this, maskCEP)" maxlength="10" onblur="pesquisaCEP(this.value);">
                            </div>

                            <!-- BAIRRO -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-lg" id="bairro" name="bairro" placeholder="Bairro" disabled>
                            </div>

                            <!-- CIDADE -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" placeholder="Cidade" disabled>
                            </div>

                            <!-- ESTADO -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-lg" id="estado" name="estado" placeholder="Estado" disabled>
                            </div>

                        </div>

                        <div class="step">
                            <!-- SENHA -->
                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-lg" id="senha" name="senha" confirmarSenha="abc(event, '#confirmaSenha', '#senhaErrada')" placeholder="Digite sua senha" autocomplete="off" required>
                            </div>

                            <!-- CONFIRMAÇÃO SENHA -->
                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-lg" id="confirmaSenha" name="confirmaSenha" onchange="confirmarSenha(event, '#senha', '#senhaErrada')" placeholder="Confirme sua senha" autocomplete="off" required>
                                <small id="senhaErrada" class="formMsgErro">As senhas precisam ser iguais</small>
                            </div>

                            <!-- div para comunicação com usuário -->
                            <div id="feedbackUsuario" class="collapse"></div>
                        </div>

                        <!-- BOTÕES AÇÃO -->
                        <div class="buttons d-flex justify-content-center align-items-center gap-3 my-3">
                            <!-- <button type="button" class="btn btn-link" onclick="redirectLogin()">Já sou usuário</button> -->
                            <button type="button" id="btnPrev" class="btn btn-dark">Anterior</button>
                            <button type="button" id="btnNext" class="btn btn-outline-dark">Próximo</button>
                            <button type="submit" id="btnSubmit" class="btn btn-outline-green">Cadastrar</button>
                        </div>
                    </form>
                </div>

                <div class="cadastro-side-image col-md-6 px-0"><img src="images\teste2.jpg" alt=""></div>
            </div>
    </main>

    <!-- FORM STEPS -->
    <script src="js/stepForm.js"></script>

    <!-- SCRIPT PARA CEP -->
    <script src="js/buscaCEP.js"></script>
</body>

</html>