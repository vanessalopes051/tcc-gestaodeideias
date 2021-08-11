
<?php

require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Inovacao.php';
require_once '../modelo/ideia/Ideia.php';
require_once '../modelo/usuario/Usuario.php';

$sessao->iniciar();

// verificação de usuario 
if($_SESSION['permissao'] != 2){
  if ($_SESSION['permissao'] != 0) {
    include_once 'telas/404.php';
    die();
  }
}

// obtendo arquivo
$autoload_2 = new Autoload('../classe/controle/');

if(isset($_GET['ideia'])){

    //obtendo dados
    $codIdeia = filter_input(INPUT_GET, 'ideia', FILTER_VALIDATE_INT);

    echo $codIdeia;

    $ideia = new Ideia;
    $ideia->setId($codIdeia);

    $usuario = new Usuario;
    $usuario->setIdeia($ideia);

    $inovacao = new Inovacao; // papel
    $inovacao->setUsuario($usuario);

    if($inovacao->finalizarIdeia($conexao)){
        IrPara::link('/index.php?executando=1');
    }

    $pdo->fecharConexao();
  
}else{
    IrPara::link('/index.php');
  }



