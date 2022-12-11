<?php
// header da requisição http para declarar que a resposta será um json
header("Content-Type: application/json");
require("../verificacoes.php");
require("../../utils.php");

session_start();
// verifyIsAuthenticated();

// classe PDO para realização de operações no BD
require("../../database/Contrato.php");
$contrato = new Contrato();

[$idContrato, $idStatus] = [$_POST["idContrato"], $_POST["idStatus"]];

// inserção da especialização no usuário
$result = $contrato->setStatusContrato($idContrato, $idStatus);

echo json_encode($result);
