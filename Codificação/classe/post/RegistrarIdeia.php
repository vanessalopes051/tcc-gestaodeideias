<?php
require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Usuario.php';
require_once '../modelo/ideia/Ideia.php';
require_once '../modelo/usuario/Colaborador.php';

$sessao->iniciar();

// verificação de usuario 
if($_SESSION['permissao'] != 3){
  if ($_SESSION['permissao'] != 0) {
    include_once 'telas/404.php';
    die();
  }
}

// obtendo arquivo
$autoload_2 = new Autoload('../classe/controle/');

if (isset($_POST['token'])) {
    if ($_SESSION['token'] == $_POST['token']) {
        $token = strval(filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS));
        $testeToken = strval($_SESSION['token']);
    
        if (strcmp($token, $testeToken) == 0) {

      //Obtendo Idéias  - FALTA TRATAR OS INPUTS
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
            $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_URL);

            //verifica se existe algum campo vázio
            //if(!Filtro::verificaCampos( Array($titulo, $descricao, $link) ) )
            //  IrPara::link('/index.php?dir=avaliacao&r=2');

            //Instância  da nova ideia, setando os atributos
            $novaIdeia = new Ideia();
            $novaIdeia->setTitulo($titulo);
            $novaIdeia->setDescricao($descricao);
            $novaIdeia->setLink($link);
  
            //Instância  de Usuário e Colaborador
            $usuario = new Usuario();
            $usuario->setIdeia($novaIdeia);
            $usuario->setId($_SESSION['codigo']);
  
            //É necessário atribuir o papel do colaborador
            $colaborador = new Colaborador();
            $usuario->setPapel($colaborador);
            $colaborador->setUsuario($usuario);

            //Pós cadastro de ideia
            if ($colaborador->cadastrarNovaIdeia($conexao)) {
                echo "<script>alert('Operação realizada!');</script>";
                IrPara::link('/index.php?sugestoes=1');
            } else {
                echo "<script>alert('Operação NÃO realizada!');</script>";
                IrPara::link('/index.php?sugestoes=0');
            }
    
            $pdo->fecharConexao();
        }
    } else {
        IrPara::link('/index.php');
    }
    
}