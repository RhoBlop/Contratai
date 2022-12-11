<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("nome", "email", "cpf", "telefone", "senha", "confirmaSenha", "bairro", "cidade", "estado");

    // termina o serviço caso alguma das variáveis esteja vazia
    verifyIsEmptyPost("nome", "email", "cpf", "telefone", "senha", "confirmaSenha");
    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $user = new Usuario();
    
    //TODO: adicionar verificação do CEP e insert no cadastro
    // destructuring das variáveis recebidas pelo POST request
    [$nome, $email, $cpf, $telefone, $nascimento, $senha, $confirmaSenha, $nomeBairro, $nomeCidade, $siglaEstado] = [$_POST["nome"], $_POST["email"], $_POST["cpf"], $_POST["telefone"],  $_POST["nascimento"], $_POST["senha"], $_POST["confirmaSenha"], $_POST["bairro"], $_POST["cidade"], $_POST["estado"]];
    
    $selectBairro = $user->selectBairroByNome($nomeBairro);
    $selectCidade = $user->selectCidadeByNome($nomeCidade);
    $selectEstado = $user->selectEstadoBySigla($siglaEstado);

    if (!$selectCidade) {
        $user->insertCidade($nomeCidade, $selectEstado['idestado']);
        $selectCidade = $user->selectCidadeByNome($nomeCidade);
        if (!$selectBairro) {
            $user->insertBairro($nomeBairro, $selectCidade['idcidade']);
            $selectBairro = $user->selectBairroByNome($nomeBairro);
        }
    }

    $bairro = $selectBairro['idbairro'];

    if ($senha == $confirmaSenha) {
        $response = $user->insertBasicInfo($nome, $email, $cpf, $telefone, $senha, $bairro, $nascimento);

        echo json_encode($response);
    }
?>