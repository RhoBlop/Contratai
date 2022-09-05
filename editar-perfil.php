<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("components/head.html") ?>
        <!--<script src="js/isAuthenticated.js"></script>  -->
    </head>
    <body>
        <?php include ("components/login-header.html") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row">
                    <ul class="navbar-nav flex-column col-2" id="side-bar">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-user fa-fw pe-3"></i>Meu perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-regular fa-bell fa-fw pe-3"></i>Notificações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-shield-halved fa-fw pe-3"></i>Segurança</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-gear fa-fw pe-3"></i>Preferências</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-screwdriver-wrench fa-fw pe-3"></i>Admin</a>
                        </li>
                        <hr>
                        <li class="nav-item text-danger">
                            <a class="nav-link" href="#"><i class="fa-solid fa-trash fa-fw pe-3"></i>Excluir Conta</a>
                        </li>
                    </ul>

                    <div class="flex-column col-8 px-3" id="profile-content">
                        <div class="mb-5">
                            <h2>Editar perfil</h2>
                            <h6 class="text-muted">Edite os dados da sua conta</h6>
                        </div>
                        
                        <img src="https://github.com/mdo.png" alt="" class="rounded-circle mb-5" height="148" width="148"> 

                        <form action="">
                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input class="form-control" type="password" id="senha" name="senha" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="164.437.627-03" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label for="regiao" class="form-label">Região</label>
                                <input type="text" class="form-control" id="regiao" name="regiao">
                            </div>
                            <div class="form-group mb-3">
                                <label for="data" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data" name="data">
                            </div>
                            <div class="form-group mb-3">
                                <label for="data" class="form-label">Bio</label>
                                <textarea class="form-control" name="bio" id="bio" rows="5"></textarea>
                            </div>
                            
                            <div class="buttons d-flex justify-content-end align-items-center">
                                <a href="perfil.php" class="btn btn-link me-3">Cancelar</a>
                                <button type="submit" class="btn btn-outline-green">Salvar Alterações</button>
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