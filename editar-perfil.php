<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("components/head.html") ?>
        <script src="js/visualizarImg.js"></script>
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
                            <h2>Editar perfil</h2>
                            <h6 class="text-muted">Edite os dados da sua conta</h6>
                        </div>
                        
                        
                        <form id="updateUser" onsubmit="sendUpdate(event)">
                            <label id="inputFileLabel" for="inputImg" class="rounded-circle mb-4">
                                <img src="images/temp/default-pic.png" id="imgPerfil" alt="">
                                <div class="editar-hover">
                                    <i class="fa-solid fa-pen"></i>
                                    <p>Editar Foto</p>
                                </div>
                            </label>
                            <input id="inputImg" type="file" name="imgPerfil" onchange="showSelectedImg(event, '#imgPerfil')">

                            <div class="form-group mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" placeholder="" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone">
                            </div>
                            <div class="form-group mb-3">
                                <label for="nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="nascimento" name="nascimento">
                            </div>
                            <div class="form-group mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="5"></textarea>
                            </div>
                            
                            <div class="buttons d-flex justify-content-end align-items-center py-3">
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

    <script>
        // seta os campos da table com os dados do usuário
        getLoggedUser()
            .then(user => {
                document.querySelector("#headerImgPerfil").src = user["imgusr"];
                document.querySelector("#imgPerfil").src = user["imgusr"];
                document.querySelector("#nome").value = user["nomusr"];
                document.querySelector("#email").value = user["emailusr"];
                document.querySelector("#cpf").value = user["cpfusr"];
                document.querySelector("#telefone").value = user["telefoneusr"];
                document.querySelector("#nascimento").value = user["nascimentousr"];
                document.querySelector("#bio").innerText = user["biografiausr"];
            })
            .catch(err => {
                console.error(err);
            })
    </script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>