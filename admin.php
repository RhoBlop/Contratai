<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/header-auth.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    

                    <?php include("components/sidebar.php")?>

                    <!-- REVIEW Deixar o template da tabela pronto para depois preenchê-la. -->
                    <div class="col-10 px-4 flex-column" id="settingsContent">

                    <div class="mb-4">
                        <h2>Administração do sistema</h2>
                    </div>
                        <?php 
                        $users = $usuarioClass->selectAllUsers();

                        ?>
                          
                        <div class="crud">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col">
                                        <h4>Gerenciamento de Usuários</h4>
                                    </div>
                                    <div class="col">
                                        <div class="crud-buttons d-flex gap-3 justify-content-end">
                                            <!-- TODO Adicionar modal para adicionar um usuário-->
                                            <a href="#add" class="btn btn-success">Adicionar [item]</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Admin?</th>
                                    <th scope="col">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        foreach($users as $user) :

                                    ?> 
                                            <!-- TODO Imprimir todos os dados no modal -->
                                            <!-- TODO Estilizar o modal -->
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?php echo 'modal'. $user['iduser']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="updateUser<?php echo $user['iduser']?>" onsubmit="sendUpdate(event)">
                                                                <label id="inputFileLabel" for="inputImg" class="rounded-circle mb-4">
                                                                    <img src="<?php echoProfileImage($user['imguser']) ?>" id="imgPerfil" alt="">
                                                                    <div class="editar-hover">
                                                                        <i class="fa-solid fa-pen"></i>
                                                                        <p>Editar Foto</p>
                                                                    </div>
                                                                </label>
                                                                <input id="inputImg" type="file" name="imgPerfil" onchange="showSelectedImg(event, '#imgPerfil')">

                                                                <div class="form-group mb-3">
                                                                    <label for="nome" class="form-label">Nome Completo</label>
                                                                    <input type="text" class="form-control" id="nome" name="nome" required value="<?php echoDadosNotNull($user['nomeuser'], null) ?>">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="email" class="form-label">Email</label>
                                                                    <input type="email" class="form-control" id="email" name="email" required value="<?php echoDadosNotNull($user['emailuser'], null) ?>">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="cpf" class="form-label">CPF</label>
                                                                    <input type="text" class="form-control" id="cpf" placeholder="" disabled value="<?php echoDadosNotNull($user['cpfuser'], null) ?>">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="telefone" class="form-label">Telefone</label>
                                                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echoDadosNotNull($user['telefoneuser'], null) ?>">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="nascimento" class="form-label">Data de Nascimento</label>
                                                                    <input type="date" class="form-control" id="nascimento" name="nascimento" value="<?php echoDadosNotNull($user['nascimentouser'], null) ?>">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="bio" class="form-label">Bio</label>
                                                                    <textarea class="form-control" id="bio" name="bio" rows="5" style="white-space: pre-wrap;"><?php echoDadosNotNull($user['biografiauser'], null) ?></textarea>
                                                                </div>

                                                                <!-- div para comunicação com usuário -->
                                                                <div id="feedbackUsuario"></div>
                                                                
                                                                <div class="buttons d-flex justify-content-end align-items-center py-3">
                                                                    <a href="perfil.php" class="btn btn-link me-3">Cancelar</a>
                                                                    <button type="submit" class="btn btn-outline-green">Salvar Alterações</button>
                                                                </div>
                                                            </form>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>




                                            <?php
                                            $admin = ($user["isadminuser"] == true) ? "Sim" : "Não";

                                            echo <<<HTML
                                                <tr>
                                                    <th scope="row">{$user["iduser"]}</th>
                                                    <td>{$user["nomeuser"]}</td>
                                                    <td>{$user["emailuser"]}</td>
                                                    <td>{$user["cpfuser"]}</td>
                                                    <td>{$user["telefoneuser"]}</td>
                                                    <td>$admin</td>
                                                    <td>
                                                        <div class="action-buttons d-flex justify-content-around">
                                                            <a href="#modal{$user['iduser']}" data-bs-toggle="modal" data-bs-target="#modal{$user['iduser']}" id="infoButton" class="btn btn-green"><i class="fa-solid fa-circle-info"></i></a>
                                                            <a href="#exlude" id="excludeButton" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            HTML; 

                                        endforeach;
                                    
                                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main> 

    </body>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>