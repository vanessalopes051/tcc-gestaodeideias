<?php

//ARQUIVO DA CAMILLA

require_once '../../Autoload.php';
require_once '../../Sessao.php';
require_once '../banco/Conexao.php';
require_once '../modelo/usuario/Usuario.php';

$sessao->iniciar();

$autoload_2 = new Autoload('../classe/controle/');

if (isset($_POST['token'])) {
    if ($_POST['token'] ==  md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {

        //Obtendo Idéias  - FALTA TRATAR OS INPUTS
        $codigoUsuario =  filter_input(INPUT_POST,'user', FILTER_VALIDATE_INT);
        $nome  =  filter_input(INPUT_POST,'nome',  FILTER_SANITIZE_SPECIAL_CHARS);
        $email =  filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
        
        // verifica se o usuário quer trocar a senha
        if(isset($_POST['senha']))
            $senha =  filter_input(INPUT_POST,'senha', FILTER_SANITIZE_SPECIAL_CHARS);
        else
            $senha = null;
        

        // apenas admin pode alterar o papel dos usuários
        if($_SESSION['permissao']==0)
            $papel =  filter_input(INPUT_POST,'papel', FILTER_VALIDATE_INT);
        else
            $papel = 4;

        //debug
        /*
            echo "<pre>";
            print_r(Array($nome, $email, $senha, $papel));
            var_dump(Filtro::verificaCampos(Array($nome, $email, $senha, $papel)));
            echo "</pre>"; 
            die();
        */

        if(Filtro::verificaCampos(Array($nome, $email, $papel, $codigoUsuario))){

            //Construindo o objeto
            $usuario = new Usuario();
            $usuario->setId($codigoUsuario);
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setPapel($papel);

            //buscando senha de usuário
            if($senha){
                $usuario->setSenha(md5($senha));
            }else{

                $obj = $usuario->lerUsuario($conexao);
                $objJson = $obj ? json_decode($obj) : null;

            /*
            //debug
            echo "<pre>";
            print_r($objJson);
            echo "</pre>"; 
            */

                $usuario->setSenha($objJson->senha);

            }        

            /*
            //debug
            echo "<pre>";
            print_r($usuario);
            echo "</pre>"; 
            die();
            */

            //atualizar usuário
            if ( $usuario->editarUsuario($conexao) ) {
                IrPara::link('/index.php?dir=usuarios&r=0');
            } else {
                IrPara::link('/index.php?dir=usuarios&r=2');
            }
          
        
            $pdo->fecharConexao();

        }else{
            die();
            IrPara::link('/index.php?dir=usuarios&r=1');
        }

    }
}

