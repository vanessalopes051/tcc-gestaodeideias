<?php
require_once '../Sessao.php';
$sessao->login();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cadastro de Usuário</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- CSS PRINCIPAL -->
    <link href="../vendor/css/cadastro.css" rel="stylesheet">

</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Cadastro</h2>

 <form action="../classe/post/CadastrarUsuario.php" method="post">
                        <!-- Possiveis erros -->

                            <!-- TOKEN USER -->
		<input type='hidden' class='form-control' name='token' value='<?php echo md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']); ?>'>


                        <div class="col-1">
                            <div class="input-group">
                                <label class="label">Nome Completo</label>
                                <input class="input--style-4" type="text" id="nome" name="nome" required>
                            </div>
                        </div>
                        

                        <div class="col-1">
                            <div class="input-group">
                                <label class="label">Email</label>
                                <input class="input--style-4" type="email" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Campos Duplo -->
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Senha</label>
                                    <input class="input--style-4" type="password" id="senha1" name="senha1" required>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Repetir Senha</label>
                                    <input class="input--style-4" type="password" id="senha2" name="senha2" required>
                                </div>
                            </div>

                        </div>
                        
                        <div class="input-group">
                            <label class="label">Selecionar Foto</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <input type="file" id="foto" name="foto" accept="image/png, image/jpeg">
                            </div>
                        </div>
                        
                    
                        <!-- Este botão está amaldiçoado, não abrir em dispositívos móveis -->
                        <div class="p-t-10">
                            <button class="btn btn--radius-2 btn--blue " name="reg_user" type="submit">Enviar</button>
                            
                        </div>
                        <a href="login.php">Login</a> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="../vendor/jquery/jquery.min.js"></script>

</body>
</html>
