<?php

//ARQUIVO DA CAMILLA

require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Usuario.php';

$autoload_2 = new Autoload('../classe/controle/');

if (isset($_POST['token'])) {
    if ($_POST['token'] ==  md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {


        //Obtendo Idéias  - FALTA TRATAR OS INPUTS
        $nome   = filter_input(INPUT_POST,'nome',   FILTER_SANITIZE_SPECIAL_CHARS);
        $email  = filter_input(INPUT_POST,'email',  FILTER_VALIDATE_EMAIL);
        $senha1 = filter_input(INPUT_POST,'senha1', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha2 = filter_input(INPUT_POST,'senha2', FILTER_SANITIZE_SPECIAL_CHARS);

        //verificar campos em branco

        if(Filtro::verificaCampos(Array($nome,$email,$senha1,$senha2))){
            //Construindo o objeto
            $usuario = new Usuario();
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setSenha($senha2);
            $usuario->setPapel(4);

            //Pós cadastro de ideia
            //Pós cadastro de ideia
            if ($usuario->adicionarUsuario($conexao)) {
                IrPara::link('/index.php?dir=index&r=0');
            } else {
                IrPara::link('/index.php?dir=index&r=1');
            }
        
            $pdo->fecharConexao();
        }else{
            IrPara::link('/index.php?dir=index&r=1');
        }


    }
}

