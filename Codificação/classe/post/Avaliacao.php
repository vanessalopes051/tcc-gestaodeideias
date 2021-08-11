<?php

require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Inovacao.php';
require_once '../modelo/ideia/Ideia.php';

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

if(isset($_POST['token'])){

    $token = strval( filter_input(INPUT_POST,'token', FILTER_SANITIZE_SPECIAL_CHARS) ); 
    $testeToken = strval( $_SESSION['token'] );

    if( strcmp( $token, $testeToken) == 0 ){

        //obtendo dados
        $codIdeia = filter_input(INPUT_POST, 'ideia', FILTER_VALIDATE_INT);
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_VALIDATE_INT);
        $usuario = filter_var($_SESSION['codigo'], FILTER_VALIDATE_INT);
        $justificativa = filter_input(INPUT_POST, 'justificativa', FILTER_VALIDATE_INT);
        $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_URL);

        //verifica se existe algum campo vázio
        if(!Filtro::verificaCampos( Array($codIdeia, $tipo, $usuario, $justificativa, $link) ) )
          IrPara::link('/index.php?dir=avaliacao&r=2');

        // instanciar novo documento
        $documento = new DocumentoAvaliacao();
        $documento->setLink($link);
        $documento->setUsuario($usuario);
        $documento->setIdeia($codIdeia);
        $documento->setTipo($tipo);    // tipo: plano de projeto
        $documento->setJustificativa($justificativa);

        // objeto equipe de inovação
        $inovacao = new Inovacao();
        $inovacao->setDocumento($documento);

        // escolher estado
        $estado = null;

        if ($justificativa == 1 || $justificativa == 2) {
            $estado = 7;
        } elseif ($justificativa == 3) {
            $estado = 2;
        }


        if (!$estado) {
            // voltar para a pagina de ideias pendentesSucesso
            IrPara::link('/index.php?dir=avaliacao&r=0');
        } else {

          // realizar primeira operação: criando documento de avaliação
            if ($inovacao->fazerAvaliacaoInicial($conexao)) {

            // objeto ideia
                $ideia = new Ideia();
                $ideia->setId($codIdeia);
                $ideia->setEstado($estado);
                // mudar estado da ideia e adicionar para o historico
                $ideia->mudarEstado($conexao);

                // voltar para a pagina de ideias pendentes
                IrPara::link('/index.php?dir=avaliacao&r=1');
            } else {
                // voltar para a pagina de ideias pendentesSucesso
                IrPara::link('/index.php?dir=avaliacao&r=0');
            }
        }


        $pdo->fecharConexao();
    }
}else{
  IrPara::link('/index.php');
}

?>