<ul class="nav nav-pills navbar-nav col-3 col-xl-2 px-3" id="sidebar">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="perfil.php"><i class="fa-solid fa-user fa-fw me-1"></i>Meu perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="profissoes.php"><i class="fa-solid fa-user-tie fa-fw me-1"></i>Profissões</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="contratos.php"><i class="fa-solid fa-address-book fa-fw me-1"></i>Contratos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="notificacoes.php"><i class="fa-solid fa-bell fa-fw me-1"></i>Notificações</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="editar-senha.php"><i class="fa-solid fa-lock fa-fw me-1"></i>Editar Senha</a>
    </li>

    <?php 
        if ($admin === true):
    ?>
        <li class="nav-item">
            <a class="nav-link" href="admin.php"><i class="fa-solid fa-screwdriver-wrench fa-fw me-1"></i>Admin</a>
        </li>
    <?php
        endif;
    ?>

    <hr>
    <li class="nav-item">
        <a href="#modal-exclude" class="nav-link link-danger" data-bs-toggle="modal" data-bs-target="#modal-exclude"><i class="fa-solid fa-trash fa-fw me-1"></i>Excluir Conta</a>
    </li>
</ul>

<?php include("components/modal-exclude.php"); ?>