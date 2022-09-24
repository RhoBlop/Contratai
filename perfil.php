<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/login-header.php") ?>

        <main>
            <div class="container p-3 my-3 mb-5">
                <div class="row gx-5">

                    <?php include("components/modal-exclude.html")?>

                    <?php include("components/sidebar.html")?>

                    <div class="col-7 px-3" id="profile-content">
                        <div class="mb-5">
                            <h2>Meu Perfil</h2>
                            <h6 class="text-muted">Dados da conta</h6>
                        </div>
                        <div class="d-flex justify-content-center ">
                            <div class="img-perfil-wrapper rounded-circle shadow-sm mb-5">
                                <img id="imgPerfil" src="<?php echoProfileImage($user["imgusr"]); ?>">
                            </div>
                        </div>
                        <table class="table mb-5">
                            <tbody>
                                <tr>
                                    <td>Nome completo</td>
                                    <td class="text-muted" id="nome"><?php echoDadosPerfil($user["nomusr"]); ?></td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td class="text-muted" id="email"><?php echoDadosPerfil($user["emailusr"]); ?></td>
                                </tr>

                                <tr>
                                    <td>Data de Nascimento</td>
                                    <td class="text-muted" id="nascimento"><?php echoFormattedDate($user["nascimentousr"]); ?></td>
                                </tr>

                                <tr>
                                    <td>Telefone</td>
                                    <td class="text-muted" id="telefone"><?php echoDadosPerfil($user["telefoneusr"]); ?></td>
                                </tr>
                                
                                <tr>
                                    <td>Bio</td>
                                    <td class="text-muted" id="bio"><?php echoDadosBreakLine($user["biografiausr"]); ?></td>
                                </tr>

                            </tbody>
                        </table>

                        <a href="editar-perfil.php" class="btn btn-outline-dark">Editar Perfil</a>

                    </div>
                </div>
            </div>
        </main>

        <?php include ("components/toast.html") ?>
    </body>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        checkForOpenToast();
    </script>
</html>