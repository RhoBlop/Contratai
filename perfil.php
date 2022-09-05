<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("components/head.html") ?>
        <!--<script src="js/isAuthenticated.js"></script>  -->
    </head>
    <body>
        <?php include ("components/login-header.html") ?>

        <main>
            <div class="container">
                <div class="row gx-5">
                    <ul class="navbar-nav flex-column col-2 my-5 mx-0" id="side-bar">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-user fa-fw pe-3"></i>Meu perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-regular fa-bell fa-fw pe-3"></i>Notificações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-shield fa-fw pe-3"></i>Segurança</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-gear fa-fw pe-3"></i>Preferências</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-screwdriver-wrench fa-fw pe-3"></i>Admin</a>
                        </li>
                        <li class="nav-item text-danger">
                            <a class="nav-link" href="#"><i class="fa-solid fa-trash fa-fw pe-3"></i>Excluir Conta</a>
                        </li>
                    </ul>

                    <div class="flex-column col-7 my-5" id="profile-content">
                        <div class="mb-5">
                            <h2>Meu Perfil</h2>
                            <h6 class="text-muted">Dados da conta</h6>
                        </div>

                        <img src="https://github.com/mdo.png" alt="" class="rounded-circle mb-5" height="214" width="214">

                        <table class="table mb-5">
                            <tbody>
                                <tr>
                                    <td>Nome completo</td>
                                    <td class="text-muted">Rafael Rodrigues</td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td class="text-muted">rafael1309mt@gmail.com</td>
                                </tr>

                                <tr>
                                    <td>Data de Nascimento</td>
                                    <td class="text-muted">13/09/2004</td>
                                </tr>

                                <tr>
                                    <td>Telefone</td>
                                    <td class="text-muted">(27) *****-0259</td>
                                </tr>

                            </tbody>
                        </table>

                        <a href="editar.php" class="btn btn-outline-dark">Editar Perfil</a>

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