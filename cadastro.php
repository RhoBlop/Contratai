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
            background: url("images/trabalhador-cadastro.png") no-repeat 0px -100px;
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
                    <div class="col-12 col-md-6 col-lg-5 d-flex flex-column justify-content-center align-items-center">
                        <!-- LOGO -->
                        <a class="cadastro-logo" href="index.php">
                            <img src="images/logo/blue-logo.svg" alt="Logo" height="70px">
                        </a>
                        
                        <!-- Título Formulário -->
                        <div class="form-title mb-5">
                            <h1>Crie sua conta!</h1>
                            <h6>Preencha suas informações</h6>
                        </div>

                        <form id="cadastro" class="form-cadastro d-flex flex-column" action="./api/apiCadastro.php" method="POST">

                            <!-- NOME -->
                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" autocomplete="off">
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email">
                            </div>

                            <!-- SENHA -->
                            <div class="form-group mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" autocomplete="off">
                            </div>

                            <!-- CONFIRMAÇÃO SENHA -->
                            <div class="form-group mb-1">
                                <label for="nome" class="form-label">Confirme sua senha</label>
                                <input type="text" class="form-control" id="nome" name="senhaConfirma" placeholder="Digite sua senha" autocomplete="off">
                            </div>

                            <a class="ms-auto mb-5">Esqueci minha senha</a>

                            <button type="submit" class="btn btn-green">Cadastrar</button>
                        </form>
                    </div>
                    <div class="cadastro-side-image col-md-6 col-lg-7"></div>
                </div>
            </div>
        </main>
        <script>
            // let form = document.querySelector("#cadastro");
            // form.addEventListener("submit", async (e) => {
            //     event.preventDefault();

            //     let formData = new URLSearchParams(new FormData(e.target)).toString();
            //     let resp = await fetch("./api/apiCadastro.php", {
            //         method: "POST",
            //         headers: {
            //             "Content-Type": "application/x-www-form-urlencoded"
            //         },
            //         body: formData
            //     })
            //     try {
            //         let data = await resp.json();
            //         console.log(data);
            //     } catch (e) {
            //         console.log(await resp.text());
            //     }
            // })

            // function sendLogin() {
            //     let data = new FormData(form);
            //     console.log(data);
            // }
        </script>
    </body>
</html>