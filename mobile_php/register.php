<?php
 

require_once('conexao_db.php');


$resposta = array();
 
if (isset($_POST['novo_nome']) && isset($_POST['novo_email']) && ($_POST['novo_cpf']) && isset($_POST['nova_senha']) && ($_POST['nova_profissao'])) {
 

	$novo_nome = trim($_POST['novo_nome']);
    $novo_email = trim($_POST['novo_email']);
    $novo_cpf = trim($_POST['novo_cpf']);
	$nova_senha = trim($_POST['nova_senha']);
    $nova_profissao = trim($_POST['nova_profissao']);
	
	
	$token = password_hash($nova_senha, PASSWORD_DEFAULT);
	
	
	$consulta_usuario_existe = db_con->prepare("SELECT emailUser FROM Usuario WHERE emailUser='$novo_email'");
	$consulta_usuario_existe->execute();
	if ($consulta_usuario_existe->rowCount() > 0) { 
	
		$resposta["sucesso"] = 0;
		$resposta["erro"] = "usuario ja cadastrado";
	}
	else {
	
		$consulta = db_con->prepare("INSERT INTO usuario(emailUser, token) VALUES('$novo_email', '$token')");
	 
		if ($consulta->execute()) {
		
			$resposta["sucesso"] = 1;
		}
		else {
			
			$resposta["sucesso"] = 0;
			$resposta["erro"] = "erro BD: " . $consulta->error;
		}
	}
}
else {
	
    $resposta["sucesso"] = 0;
	$resposta["erro"] = "faltam parametros";
}

$db_con = null;

echo json_encode($resposta);
?>