
<?php

require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Patrocinador.php';
require_once '../modelo/ideia/Ideia.php';

$sessao->iniciar();

// verificação de usuario 
if($_SESSION['permissao'] != 4){
  if ($_SESSION['permissao'] != 0) {
    include_once 'telas/404.php';
    die();
  }
}

// obtendo arquivo
$autoload_2 = new Autoload('../classe/controle/');

if(isset($_POST['token'])){

  $token = strval( filter_input(INPUT_POST,'token', FILTER_SANITIZE_SPECIAL_CHARS) ); 
  $testeToken = strval( $_SESSION['token'] );

  if( strcmp( $token, $testeToken) == 0 ){

    //obtendo dados
    $codIdeia = filter_input(INPUT_POST, 'ideia', FILTER_VALIDATE_INT);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_VALIDATE_INT);
    $usuario = filter_var($_SESSION['codigo'], FILTER_VALIDATE_INT);
    $justificativa = filter_input(INPUT_POST, 'justificativa', FILTER_VALIDATE_INT);

    //verifica se existe algum campo vázio
    if(!Filtro::verificaCampos( Array($codIdeia, $tipo, $usuario, $justificativa) ) )
      IrPara::link('/index.php?dir=selecionar&r=2');

    // instanciar novo documento
    $documento = new DocumentoAvaliacao();
    $documento->setLink(null);
    $documento->setUsuario($usuario);
    $documento->setIdeia($codIdeia);
    $documento->setTipo($tipo);    // tipo: plano de projeto
    $documento->setJustificativa($justificativa);

    // objeto equipe de inovação
    $patrocinador = new Patrocinador();
    $patrocinador->setDocumento($documento);

      // escolher estado
      $estado = null;

      if ($justificativa == 2) {
          $estado = 7;
      } elseif ($justificativa == 3) {
          $estado = 5;
      }


      // realizar primeira operação: criando documento de avaliação
      if ($patrocinador->selecionarIdeiaInovadora($conexao)) {

        // objeto ideia
          $ideia = new Ideia();
          $ideia->setId($codIdeia);
          $ideia->setEstado($estado);
          // mudar estado da ideia
          $ideia->mudarEstado($conexao);
        
          // voltar para a pagina de ideias pendentes
          IrPara::link('/index.php?dir=selecionar&r=1');
      } else {
          // voltar para a pagina de ideias pendentesSucesso
          IrPara::link('/index.php?dir=selecionar&r=0');
      }


      $pdo->fecharConexao();
  }
}else{
  IrPara::link('/index.php');
}

?>