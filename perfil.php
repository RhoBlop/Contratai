<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("components/head.php") ?>
</head>

<body>
    <?php include("components/auth-header.php") ?>

    <main>
        <div class="container p-3 my-3 mb-5">
            <div class="row gx-5">
                <?php include("components/sidebar.php") ?>

                <div class="col-7 px-3" id="settingsContent">
                    <div class="mb-5">
                        <h2>Meu Perfil</h2>
                        <div class="div d-flex justify-content-between align-items-center">
                            <h6 class="text-muted m-0">Dados da conta</h6>
                            <a href="<?php echo "perfil-publico.php?id={$user["iduser"]}" ?>" class="text-decoration-none">Visualizar seu perfil público</a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <img id="imgPerfil" src="<?php echoProfileImage($user["imguser"]); ?>" alt="Imagem de Perfil">
                    </div>
                    <table class="table mb-5">
                        <tbody>
                            <tr>
                                <td>Nome</td>
                                <td class="text-muted" id="nome"><?php echoDadosNotNull($user["nomeuser"], "---"); ?></td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td class="text-muted" id="email"><?php echoDadosNotNull($user["emailuser"], "---"); ?></td>
                            </tr>

                            <tr>
                                <td>CPF</td>
                                <td class="text-muted" id="nascimento"><?php echoDadosNotNUll($user["cpfuser"], "---"); ?></td>
                            </tr>

                            <tr>
                                <td>Data de Nascimento</td>
                                <td class="text-muted" id="nascimento"><?php echoFormattedDate($user["nascimentouser"]); ?></td>
                            </tr>

                            <tr>
                                <td>Telefone</td>
                                <td class="text-muted" id="telefone"><?php echoDadosNotNull($user["telefoneuser"], "---"); ?></td>
                            </tr>

                            <tr>
                                <td>Bio</td>
                                <td class="text-muted" id="bio"><?php echoDadosBreakLine($user["biografiauser"]); ?></td>
                            </tr>

                        </tbody>
                    </table>

                    <a href="editar-perfil.php" class="btn btn-outline-dark">Editar Perfil</a>

                </div>
            </div>
        </div>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    checkForOpenToast();
</script>

</html>