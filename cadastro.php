<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
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

                <div class="col-md-6 d-flex flex-column justify-content-center align-items-center my-2">

                    <!-- Título Formulário -->
                    <div class="form-title my-3">
                        <h2>Crie sua conta!</h2>
                    </div>

                    <form id="cadastro" class="form-cadastro row p-3 p-lg-0" autocomplete="off" onsubmit="sendCadastro(event, '#feedbackUsuario')">
                        <div class="step">
                            <!-- NOME -->
                            <div class="form-group mb-2">
                                <label for="nome" class="mb-1">Nome</label>
                                <input type="text" class="form-control form-control-lg" id="nome" name="nome" placeholder="Rafael Rodrigues " autocomplete="off" required>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group mb-2">
                                <label for="email" class="mb-1">Email</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="exemplo@exemplo.com" required>
                            </div>

                            <!-- TELEFONE --> 
                            <div class="form-group mb-2">
                                <label for="telefone" class="mb-1">Telefone</label>
                                <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" placeholder="(__) ____-____" required oninput="setMask(this, maskTelefone)" maxlength="15">
                            </div>

                            <!-- SENHA -->
                            <div class="form-group mb-2">
                                <label for="senha" class="mb-1">Senha</label>
                                <input type="password" class="form-control form-control-lg" id="senha" name="senha" confirmarSenha="abc(event, '#confirmaSenha', '#senhaErrada')" autocomplete="off" required>
                            </div>

                            <!-- CONFIRMAÇÃO SENHA -->
                            <div class="form-group mb-2">
                                <label for="confirmaSenha" class="mb-1">Confirme sua senha</label>
                                <input type="password" class="form-control form-control-lg" id="confirmaSenha" name="confirmaSenha" onchange="confirmarSenha(event, '#senha', '#senhaErrada')" autocomplete="off" required>
                                <small id="senhaErrada" class="formMsgErro">As senhas precisam ser iguais</small>
                            </div>
                        </div>

                        <div class="step">
                            <!-- CPF -->
                            <div class="form-group mb-2">
                                <label for="cpf" class="mb-1">CPF</label>
                                <input type="text" class="form-control form-control-lg" id="cpf" name="cpf" placeholder="___.____.___-__" required oninput="setMask(this, maskCPF)" onchange="validaCPF(this.value)" maxlength="14">
                            </div>
                            
                            <!-- NASCIMENTO -->
                            <div class="form-group mb-2" id="dateWrapper">
                                <label for="nascimento" class="mb-1">Data de Nascimento</label>
                                <input type="date" class="form-control form-control-lg" id="nascimento" name="nascimento">
                            </div>
                            
                            <!-- CEP -->
                            <div class="form-group mb-2">
                                <label for="cep" class="mb-1">CEP</label>
                                <input type="text" class="form-control form-control-lg" id="cep" name="cep" placeholder="_____-___" required oninput="setMask(this, maskCEP)" maxlength="9" onchange="pesquisaCEP(this.value);">
                            </div>


                            <!-- BAIRRO -->
                            <div class="form-group mb-2">
                                <label for="bairro" class="mb-1">Bairro</label>
                                <input type="text" class="form-control form-control-lg" id="bairro" name="bairro" placeholder="---" readonly>
                            </div>

                            <div class="row">
                                <!-- CIDADE -->
                                <div class="form-group mb-2 col-8">
                                    <label for="cidade" class="mb-1">Cidade</label>
                                    <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" placeholder="---" readonly>
                                </div>
    
                                <!-- ESTADO -->
                                <div class="form-group mb-2 col-4">
                                    <label for="estado" class="mb-1">Estado</label>
                                    <input type="text" class="form-control form-control-lg" id="estado" name="estado" placeholder="---" readonly>
                                </div>
                            </div>

                        </div>
                        
                        <!-- div para comunicação com usuário -->
                        <div id="feedbackUsuario" class="collapse feedbackUsuario"></div>

                        <!-- BOTÕES AÇÃO -->
                        <div class="buttons d-flex justify-content-center align-items-center gap-3 my-3">
                            <!-- <button type="button" class="btn btn-link" onclick="redirectLogin()">Já sou usuário</button> -->
                            <button type="button" id="btnPrev" class="btn btn-dark" onclick="">Anterior</button>
                            <button type="button" id="btnNext" class="btn btn-outline-dark">Próximo</button>
                            <button type="submit" id="btnSubmit" class="btn btn-outline-green">Cadastrar</button>
                        </div>
                    </form>
                </div>

                <div class="cadastro-side-image col-md-6 px-0"><img src="images\side-cadastro.jpg" alt=""></div>
            </div>
    </main>

    <!-- FORM STEPS -->
    <script src="js/stepForm.js"></script>

    <!-- SCRIPT PARA CEP -->
    <script src="js/buscaCEP.js"></script>

    <!-- VALIDAÇÃO DE CPF -->
    <script src="js/validaCPF.js"></script>

    <!-- SCRIPT PARA CALENDÁRIO -->
    <script>
        const dateInputWrapper = document.querySelector("#dateWrapper");
        let configs = {
            locale: "pt",
            mode: "multiple",
            wrap: true,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j \\d\\e M, Y",
            conjunction: " || ",
            minDate: "today",
            maxDate: new Date().fp_incr(150),
        }

        const datePicker = flatpickr(dateInputWrapper, configs);
    </script>

</body>

</html>