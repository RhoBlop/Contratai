        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/CRUD/header-admin.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5 justify-content-center">

                    <!-- REVIEW Deixar o template da tabela pronto para depois preenchê-la. -->
                    <div class="col-10 px-4 flex-column">

                    <div class="mb-4 text-center">
                        <h2>Administração do sistema</h2>
                    </div>
                        <?php 
                            $usersLimit = 10;
                            $currPage = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? $_GET["page"] : 1;
                            $allUsers = $usuarioClass->selectAllUsers();
                            $totalUsers = count($allUsers);
                            $totalPages = ceil($totalUsers / $usersLimit);
                            $usersOffset = $usersLimit * ($currPage - 1);

                            $users = $usuarioClass->selectAllUsersPagination($usersLimit, $usersOffset);

                            //Modal de Inserts
                            include ("components/CRUD/modal-addUser.php");
                            ?>

                          
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
                                                <?php include ("components/CRUD/modal-editUser.php")?>

                                                <!-- Modal de Exclusão-->
                                                <?php include ("components/CRUD/modal-excludeUser.php") ?>

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
                                            
                                            if ($i == $currPage) {
                                                echo <<<HTML
                                                <li class="page-item"><a class="page-link active" href="admin.php?page={$i}">$i</a></li>
                                                HTML;
                                            }
                                            else {
                                                echo <<<HTML
                                                <li class="page-item"><a class="page-link" href="admin.php?page={$i}">$i</a></li>
                                                HTML;
                                            }
                                            
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