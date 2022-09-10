<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("components/head.html") ?>
    </head>
    <style>
        .form-row > div {
            min-height: 100vh;
        }

        .cadastro-logo {
            position: absolute;
            top: 40px;
        }

        .form-cadastro {
            width: 80%;
            max-width: 420px;
        }

        .form-group {
            width: 100%;
        }

        .cadastro-side-image {
            background: url("images/teste2.jpg") no-repeat 0px -100px;
            background-size: cover;
        }

        .btn-green {
            color: #fff;
            border: 1.8px solid #026773;
            background-color: #026773;
            transition: transform .15s ease-in-out;
            border-radius: 12px;
            height: 50px;
        }
        .btn-green:hover {
            color: #fff;
            border-color: #026773;
            background-color: #026773;
            transform: scale(1.1);
        }

        @media screen and (max-width: 1400px) {
            .cadastro-side-image {
                background-position: top;
            }
        }

        @media screen and (max-width: 768px) {
            .cadastro-side-image {
                z-index: -1;
                min-height: 100vh;
                position: absolute;
            }
            .form-cadastro {
                background: #fff;
                border-radius: 12px;
                padding: 50px;
            }
        }
    </style>

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

                        <form id="cadastro" class="form-cadastro d-flex flex-column" onsubmit="sendCadastro(event)">

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
                                <input type="password" class="form-control" id="nome" name="confirmSenha" placeholder="Digite sua senha" autocomplete="off" required>
                            </div>

                            <a class="ms-auto mb-5">Esqueci minha senha</a>

                            <button type="submit" class="btn btn-green">Cadastrar</button>
                        </form>
                    </div>

                    <div class="cadastro-side-image col-md-6"></div>
                </div>
            </div>
        </main>
    </body>
</html>