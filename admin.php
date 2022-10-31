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

                                        foreach($users as $user) {
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
                                                        <div class="action-buttons">
                                                            <a href="#info" id="infoButton"><i class="fa-solid fa-circle-info"></i></a>
                                                            <a href="#exlude" id="excludeButton"><i class="fa-solid fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            HTML; 

                                        }
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