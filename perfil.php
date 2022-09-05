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
                <div class="row">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Meu perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Notificações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Segurança</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Preferências</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Admin</a>
                        </li>
                    </ul>
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