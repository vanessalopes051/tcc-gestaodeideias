<?php 
require_once '../Sessao.php';
$sessao->login();
// obtendo arquivo
//$autoload = new Autoload('classe/controle/');
// verifica se o get possui algum codigo para mostrar mensagem
$e = $_GET ? preg_replace('/\D/', '', $_GET['e']) : null;

switch ($e) {
  case 1:
    echo Mensagem::Error("Você precisa efetuar Login!");
    break;
  case 2:
  // TENTATIVAS 3 = AQUI ENTRA O SCRIPT DE SEGURANÇA PARA O USUARIO RESPONDER UMA VALIDAÇÃO
    echo Mensagem::Error("Email ou Senha Incorretos, tente novamente!");
    break;
  case 3:
    echo Mensagem::Error("Preencha todos os campos!");
    break;
  default:
    break;
}

  // adicionando codificação UTF 8 para página
  // header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="pt-BR"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../vendor/img/bulb.svg">

    <title>GI Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="../vendor/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../vendor/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action='../classe/post/UsuarioLogin.php' method='post'>
      <img class="mb-4" src="../vendor/img/bulb.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">GI Login</h1>

    <!-- TOKEN USER -->
		<input type='hidden' class='form-control' name='token' value='<?php echo md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']); ?>'>

      <label for="inputEmail" class="sr-only"> Email </label>
      <input id="inputEmail" name="email" class="form-control" placeholder="Email" required="" autofocus="" type="email">
      <label for="inputPassword" class="sr-only">Senha</label>
      <input id="inputPassword" name="senha" class="form-control" placeholder="Senha" required="" type="password">
      <div class="checkbox mb-3">
        <label>
          <input value="remember-me" type="checkbox"> Relembrar me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

      <a href="cadastro.php">Cadastre-se</a> 

      <p class="mt-5 mb-3 text-muted">© GI | Gestão de Ideias | <?php echo date('Y'); ?>  </p>
    </form>
  

</body></html>