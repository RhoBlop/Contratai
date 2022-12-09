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
                            $usersLimit = 5;
                            $currPage = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? $_GET["page"] : 1;
                            $allUsers = $usuarioClass->selectAllUsers();
                            $totalUsers = count($allUsers);
                            $totalPages = ceil($totalUsers / $usersLimit);
                            $usersOffset = $usersLimit * ($currPage - 1);

                            $users = $usuarioClass->selectAllUsersPagination($usersLimit, $usersOffset);
                        ?>

                        <!-- Modal de Inserts-->
                        <div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h2 class="modal-title w-100">Adicionar Usuário</h2>
                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="addUser" class="add-user row p-3" autocomplete="off" onsubmit="insertUsuario(event, '#feedbackUsuario')">
                                            <div class="step">
                                                <!-- NOME -->
                                                <div class="form-group mb-2">
                                                    <label for="nome" class="mb-1">Nome</label>
                                                    <input type="text" class="form-control " id="nome" name="nome" placeholder="Rafael Rodrigues " autocomplete="off" required>
                                                </div>
    
                                                <!-- EMAIL -->
                                                <div class="form-group mb-2">
                                                    <label for="email" class="mb-1">Email</label>
                                                    <input type="email" class="form-control " id="email" name="email" placeholder="exemplo@exemplo.com" required>
                                                </div>
    
                                                <!-- TELEFONE --> 
                                                <div class="form-group mb-2">
                                                    <label for="telefone" class="mb-1">Telefone</label>
                                                    <input type="text" class="form-control " id="telefone" name="telefone" placeholder="(__) ____-____" required oninput="setMask(this, maskTelefone)" maxlength="15">
                                                </div>
    
                                                <!-- SENHA -->
                                                <div class="form-group mb-2">
                                                    <label for="senha" class="mb-1">Senha</label>
                                                    <input type="password" class="form-control " id="senha" name="senha" confirmarSenha="abc(event, '#confirmaSenha', '#senhaErrada')" autocomplete="off" required>
                                                </div>
    
                                                <!-- CONFIRMAÇÃO SENHA -->
                                                <div class="form-group mb-2">
                                                    <label for="confirmaSenha" class="mb-1">Confirme sua senha</label>
                                                    <input type="password" class="form-control " id="confirmaSenha" name="confirmaSenha" onchange="confirmarSenha(event, '#senha', '#senhaErrada')" autocomplete="off" required>
                                                    <small id="senhaErrada" class="formMsgErro">As senhas precisam ser iguais</small>
                                                </div>
                                            </div>
    
                                            <div class="step">
                                                <!-- CPF -->
                                                <div class="form-group mb-2">
                                                    <label for="cpf" class="mb-1">CPF</label>
                                                    <input type="text" class="form-control " id="cpf" name="cpf" placeholder="___.____.___-__" required oninput="setMask(this, maskCPF)" maxlength="14" onchange  ="validaCPF(this.value)">
                                                </div>
                                                
                                                <!-- CEP -->
                                                <div class="form-group mb-2">
                                                    <label for="cep" class="mb-1">CEP</label>
                                                    <input type="text" class="form-control " id="cep" name="cep" placeholder="_____-___" required oninput="setMask(this, maskCEP)" maxlength="9" onchange="pesquisaCEP(this.value);">
                                                </div>
    
                                                <!-- BAIRRO -->
                                                <div class="form-group mb-2">
                                                    <label for="bairro" class="mb-1">Bairro</label>
                                                    <input type="text" class="form-control " id="bairro" name="bairro" placeholder="---" disabled>
                                                </div>
    
                                                <div class="row">
                                                    <!-- CIDADE -->
                                                    <div class="form-group mb-2 col-8">
                                                        <label for="cidade" class="mb-1">Cidade</label>
                                                        <input type="text" class="form-control " id="cidade" name="cidade" placeholder="---" disabled>
                                                    </div>
                        
                                                    <!-- ESTADO -->
                                                    <div class="form-group mb-2 col-4">
                                                        <label for="estado" class="mb-1">Estado</label>
                                                        <input type="text" class="form-control " id="estado" name="estado" placeholder="---" disabled>
                                                    </div>
                                                </div>
    
                                            </div>
                                            
                                            <!-- div para comunicação com usuário -->
                                            <div id="feedbackUsuario" class="collapse"></div>
    
                                            <!-- BOTÕES AÇÃO -->
                                            <div class="buttons d-flex justify-content-center align-items-center gap-3 my-3">
                                                <!-- <button type="button" class="btn btn-link" onclick="redirectLogin()">Já sou usuário</button> -->
                                                <button type="button" id="btnPrev" class="btn btn-dark" onclick="">Anterior</button>
                                                <button type="button" id="btnNext" class="btn btn-outline-dark">Próximo</button>
                                                <button type="submit" id="btnSubmit" class="btn btn-outline-green">Cadastrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                          
                        <div class="crud">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col">
                                        <h4>Gerenciamento de Usuários</h4>
                                    </div>
                                    <div class="col">
                                        <div class="crud-buttons d-flex gap-3 justify-content-end">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalAddUser" class="btn btn-success">Adicionar novo usuário</a>
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
                                                <!-- Modal de informações -->
                                                <div class="modal fade" id="<?php echo 'modalInfo'. $user['iduser']?>" tabindex="-1" aria-labelledby="<?php echo 'modalInfo'. $user['iduser']?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 text-center" id="modalTitle">Mais informações</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="updateUser-<?php echo $user['iduser']?>" onsubmit="sendUpdateAdmin(event, <?php echo $user['iduser']?>)">
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
                                                                <div id="feedbackUsuario-<?php echo $user['iduser']?>"></div>
                                                                
                                                                <div class="buttons d-flex justify-content-end align-items-center py-3">
                                                                    <a data-bs-dismiss="modal" class="btn btn-link me-3">Cancelar</a>
                                                                    <button type="submit" class="btn btn-outline-green">Salvar Alterações</button>
                                                                </div>
                                                            </form>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>

                                                <!-- Modal de Exclusão-->
                                                <div class="modal fade" id="<?php echo 'modalExclude'. $user['iduser']?>" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center">
                                                        <h3 class="modal-title w-100" id="modalExclude">Aviso</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                        <p>Você está prestes a excluir esta conta permanentemente.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="button" class="btn btn-danger" onclick="deleteUserById(<?php echo $user['iduser']?>)">Excluir</button>
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
                                                            <a href="#modalInfo{$user['iduser']}" data-bs-toggle="modal" data-bs-target="#modalInfo{$user['iduser']}" id="infoButton" class="btn btn-green"><i class="fa-solid fa-circle-info"></i></a>
                                                            <a href="#modalExclude{$user['iduser']}" data-bs-toggle="modal" data-bs-target="#modalExclude{$user['iduser']}" id="excludeButton" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            HTML; 

                                        endforeach;
                                    
                                            ?>
                                </tbody>
                            </table>
                            <nav aria-label="Pagination">
                                <ul class="pagination justify-content-center" id="pagination">
                                    <?php 
                                        //Botão de Anterior
                                        if ($currPage >1) {
                                            $prevPage = $currPage-1;
                                            echo <<<HTML
                                            <li class="page-item"><a class="page-link" href="admin.php?page={$prevPage}">Anterior</a></li>
                                            HTML;
                                        }

                                        else {
                                            echo <<<HTML
                                            <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                            HTML;
                                        }

                                        //Botões das páginas
                                        for ($i = 1; $i<= $totalPages; $i++) {
                                            echo <<<HTML
                                                <li class="page-item"><a class="page-link" href="admin.php?page={$i}">$i</a></li>
                                            HTML;
                                        }


                                        //Botão de Próximo
                                        if ($currPage < $totalPages ) {
                                            $nextPage = $currPage+1;
                                            echo <<<HTML
                                            <li class="page-item"><a class="page-link" href="admin.php?page={$nextPage}">Próximo</a></li>
                                            HTML;
                                        }

                                        else {
                                            echo <<<HTML
                                            <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                                            HTML;
                                        }
                                    ?>
                                </ul>
                            </nav>
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
    <!-- FORM STEPS -->
    <script src="js/stepForm.js"></script>
</html>