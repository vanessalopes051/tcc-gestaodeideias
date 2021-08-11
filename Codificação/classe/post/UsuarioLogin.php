<?php

require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Usuario.php';

// obtendo arquivo
$autoload_2 = new Autoload('../classe/controle/');

if(isset($_POST['token'])){ 

	$token = strval( filter_input(INPUT_POST,'token', FILTER_SANITIZE_SPECIAL_CHARS) ); 
	$testeToken = strval( md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']) );

	if( strcmp( $token, $testeToken) == 0 ){

		if(!isset($_POST['senha']) || !isset($_POST['email'])){		
			IrPara::link('/telas/login.php?e=3');
		}

		//$senha = $_POST['senha']; // senha
		$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
		//$email = $_POST['email'];  // email
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

		// objeto para verificar credenciais
		$usuario = new Usuario;
		$usuario->setEmail($email);
		$usuario->setSenha($senha);

		if($objJson = $usuario->verificarCredenciais($conexao)){

			
			$obj = json_decode($objJson);
		
			if($obj[0]){ // se objeto for verdadeiro

				$data = date(DATE_RFC822);

				//          0=>$row['id'], 1=>$row['nome'], 2=>$row['email'], 3=>$row['conta'], 4=>$row['permissao'], 5=> utf8_encode($row['papel'])
				$array = Array(0=>$obj[0], 1=>$obj[1], 2=>$obj[2], 3=>$obj[3], 4=>$obj[4], 5=>$obj[5], 6 => $data, 7 => md5($obj[2].$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
				// Array(0 => 'codigo', 1 => 'nome', 2 => 'email', 3 => 'conta', 4 => 'permissao', 5 => 'papel', 6 => 'inicio', 7 => 'token');
				$sessao->nova($array);
				IrPara::link('/index.php');
				
			}else{
				$sessao->apagar(true); // passar o parametro apenas para apagar a sessão
				IrPara::link('/telas/login.php?e=2');
			}

		}else{
			IrPara::link('/telas/login.php?e=2');
		}
		
		//fechar conexao
		$pdo->fecharConexao();

	}
	
}else{
	IrPara::link('/index.php');
}
