<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("components/head.html") ?>
        <script src="js/requisicoesAPI.js"></script>
        <script src="js/selecionarImg.js"></script>
    </head>
    <body>
        <?php include ("components/login-header.html") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    
                    <?php include("components/modal-exclude.html")?>

                    <?php include("components/sidebar.html")?>

                    <div class="col-8 px-3" id="profile-content">
                        <div class="mb-4">
                            <h2>Editar senha</h2>
                            <h6 class="text-muted">Altere a senha da sua conta</h6>
                        </div>
                        
                        
                        <form id="updateUser" onsubmit="sendUpdate(event)">
                        
                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Senha Atual</label>
                                <input type="password" class="form-control" id="senha-atual" name="senha-atual">
                            </div>

                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="nova-senha" name="nova-senha">
                            </div>

                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Confirme a nova senha</label>
                                <input type="password" class="form-control" id="nova-senha-confirma" name="nova-senha-confirma">
                            </div>
                            
                            <div class="buttons d-flex justify-content-end align-items-center py-3">
                                <a href="perfil.php" class="btn btn-link me-3">Cancelar</a>
                                <button type="submit" class="btn btn-outline-green">Salvar nova senha</button>
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