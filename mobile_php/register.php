<?php
 
/*
 * O código abaixo registra um novo usuário.
 * Método do tipo POST.
 */

require_once('conexao_db.php');

// array de resposta
$resposta = array();
 
// verifica se todos os campos necessários foram enviados ao servidor
if (isset($_POST['novo_nome']) && isset($_POST['novo_email']) && ($_POST['novo_cpf']) && isset($_POST['nova_senha']) && ($_POST['nova_profissao'])) {
 
    // o método trim elimina caracteres especiais/ocultos da string
	$novo_nome = trim($_POST['novo_nome']);
    $novo_email = trim($_POST['novo_email']);
    $novo_cpf = trim($_POST['novo_cpf']);
	$nova_senha = trim($_POST['nova_senha']);
    $nova_profissao = trim($_POST['nova_profissao']);
	
	// o bd não armazena diretamente a senha do usuário, mas sim 
	// um código hash que é gerado a partir da senha.
	$token = password_hash($nova_senha, PASSWORD_DEFAULT);
	
	// antes de registrar o novo usuário, verificamos se ele já
	// não existe.
	$consulta_usuario_existe = db_con->prepare("SELECT emailUser FROM Usuario WHERE emailUser='$novo_email'");
	$consulta_usuario_existe->execute();
	if ($consulta_usuario_existe->rowCount() > 0) { 
		// se já existe um usuario para login
		// indicamos que a operação não teve sucesso e o motivo
		// no campo de erro.
		$resposta["sucesso"] = 0;
		$resposta["erro"] = "usuario ja cadastrado";
	}
	else {
		// se o usuário ainda não existe, inserimos ele no bd.
		$consulta = db_con->prepare("INSERT INTO usuario(emailUser, token) VALUES('$novo_email', '$token')");
	 
		if ($consulta->execute()) {
			// se a consulta deu certo, indicamos sucesso na operação.
			$resposta["sucesso"] = 1;
		}
		else {
			// se houve erro na consulta, indicamos que não houve sucesso
			// na operação e o motivo no campo de erro.
			$resposta["sucesso"] = 0;
			$resposta["erro"] = "erro BD: " . $consulta->error;
		}
	}
}
else {
	// se não foram enviados todos os parâmetros para o servidor, 
	// indicamos que não houve sucesso
	// na operação e o motivo no campo de erro.
    $resposta["sucesso"] = 0;
	$resposta["erro"] = "faltam parametros";
}

// A conexão com o bd sempre tem que ser fechada
$db_con = null;

// converte o array de resposta em uma string no formato JSON e 
// imprime na tela.
echo json_encode($resposta);
?>