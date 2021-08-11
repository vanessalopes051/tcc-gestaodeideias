<?php 

include_once 'classe/modelo/ideia/Ideia.php';
include_once 'classe/banco/Conexao.php';
include_once 'classe/controle/Mensagem.php';
include_once 'classe/modelo/usuario/Usuario.php';
include_once 'classe/modelo/usuario/Papel.php';
include_once 'Sessao.php';

$sessao->iniciar();

// carregar conexao

// aguardar resposta
if (isset($_GET['r'])) {
    switch ($_GET['r']) {
    case 0:
      echo Mensagem::Sucesso("Alterações realizadas! Na próxima vez que logar, já estarão disponíveis.");
      break;
    case 1:
      echo Mensagem::Sucesso("Todos os campos são obrigatórios, com exceção da senha!");
      // no break
    default:
      echo Mensagem::Error("Operação não realizada: Erro no banco de dados!");
      break;
  }
} 

// carregar papeis
$papel = new Papel;
$papeis = $papel->lerPapel($conexao);

//print_r($papeis);

// carregar dados do usuário
$codigoUsuario = null;
// caso seja o admin, verifica se o mesmo que acessar algum perfil
if(isset($_GET['cod_usuario'])){
    if($_SESSION['permissao'] == 0)
        $codigoUsuario = filter_input(INPUT_GET, 'cod_usuario', FILTER_VALIDATE_INT);
    else{
        include_once 'telas/404.php';
        die();
    }

}else{
    // caso não queira/não seja usa o codigo na sessão
    $codigoUsuario = $_SESSION['codigo'];
}

$usuario = new Usuario;
$usuario->setId($codigoUsuario);
$objJson = null;

if( isset($_GET['all']) && $_SESSION['permissao']==0 ){

  if($_GET['all'] != 1){
    include_once 'telas/404.php';
    die();
  }

  $objJson = $usuario->lerUsuarios($conexao);

}    
else
    $objJson = $usuario->lerUsuario($conexao);

$objUsuario = $objJson ? json_decode($objJson) : null;

?>


<hr class="sidebar-divider d-none d-md-block">
          
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
           <!-- -->
          </div>
          
          </ul>
          <!-- End of Sidebar -->
                       
          <!-- Main Content -->
          <div id="content">
          
            <!-- Begin Page Content -->
            <div class="container-fluid">
              <!-- DataTales Example -->
              <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Perfil</h6>
              </div>
                <div class="card-body">


<?php 

if(count($objUsuario) == 1){

?>

<form action="classe/post/AtualizarUsuario.php" method="post">
                       
        <!-- TOKEN USER -->
		<input type='hidden' class='form-control' name='token' value='<?php echo md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']); ?>'>
        <!-- USER -->
        <input type='hidden' class='form-control' name='user' value='<?=$objUsuario->id?>'>


                        <div class="col-4">
                            <div class="input-group">
                                <label class="label">Nome Completo</label>
                                <input class="input--style-4" type="text" id="nome" name="nome" required value='<?=$objUsuario->nome?>'>
                            </div>
                        </div>
                        
                        <br>

                        <div class="col-1">
                            <div class="input-group">
                                <label class="label">Email</label>
                                <input class="input--style-4" type="email" id="email" name="email" required value='<?=$objUsuario->email?>'>
                            </div>
                        </div>

                        <br>

                        <div class="col-4">
                            <div class="input-group">
                                <label class="label">Para alterar a senha, basta digitar uma nova senha</label>
                                <input class="input--style-4" type="password" id="senha" name="senha" >
                            </div>
                        </div>

                        
                        <!--
                        <div class="input-group">
                            <label class="label">Selecionar Foto</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <input type="file" id="foto" name="foto" accept="image/png, image/jpeg">
                            </div>
                        </div>
                        -->
                        <br>
                
                        <div class="col-4">
                            <label class="label">Papel</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                        <?php 
                        if($_SESSION['permissao'] == 0){                        ?>

                                <select name='papel'>
                                <?php
                                    
                                     echo "<option value='".$objUsuario->papel."'>".$objUsuario->nomePapel."</input>";

                                    foreach ($papeis as $key => $value) {
                                        $arr = json_decode($value);
                                        if($arr->id != $objUsuario->papel)
                                            echo "<option value='".$arr->id."'>".$arr->nome."</input>";                                        
                                    }
                                ?>                                
                                </select>                         
                        <?php
                        }else{
                        ?>
                            <input class="input--style-4" type="text" id="papel" name="papel" value=<?=$objUsuario->nomePapel?> disabled>
                        <?php
                        }
                        ?>
                            </div>
                        </div>

                            <br>                  
                    
                    <div class="col-4">
                        <div class="input-group">
                            <button type='submit'  class='btn btn-primary'>Salvar</button>
                            <a href='index.php'>voltar</a>                                
                        </div>
                    </div>
</form>

<?php 
}else if(count($objUsuario) > 1){

?>

        
            <!-- Nav Item - Tables -->
               <!-- Divider -->
               <hr class="sidebar-divider d-none d-md-block">
        
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
         <!-- -->
        </div>
        
        </ul>
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
        
        <!-- Main Content -->
        <div id="content">
        
          <!-- Begin Page Content -->
          <div class="container-fluid">
        
          <h4 class="h3 mb-2 text-gray-800">Outros usuários</h4>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">

         <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Buscar:</h6>


          <!--formulário de pesquisa e filtros -->
          <form action="" method="" onsubmit=" return false;">
            <div class="form-group input-group"> 
                    <input name="consulta" id="txt_consulta" placeholder="Consultar Usuário" type="text" class="form-control">
              <a class="btn btn-default" ><i class="fa fa-fw fa-sync"></i> Limpar</a>
            </div>
          </form>


            </div>


            <div class="card-header py-3">
            </div>
              <div class="card-body">
                <div class="table-responsive">
                 

                  <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>      
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Papel</th>
                      </tr>
                    </thead>
                    <tbody>
        
                    <?php

                      foreach ($objUsuario as $key => $value) {

                        $user = json_decode($value);
                      
                        echo "<tr>";
                        echo "<td><a href='index.php?dir=usuarios&cod_usuario=".$user->id."'>".$user->nome."</a></td>"; 
                        echo "<td>".$user->email."</td>"; 
                        echo "<td>".$user->nomePapel."</td>";
                        echo "</tr>";
                        
                      }

                    ?>

        
                    </tbody>
                  </table>



                </div>
              </div>
            </div>
        
          </div>
          <!-- /.container-fluid -->


<?php }?>

</div>
</div>