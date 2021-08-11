<?php 

include_once 'classe/modelo/ideia/Ideia.php';
include_once 'classe/banco/Conexao.php';
include_once 'classe/controle/Mensagem.php';
include_once 'classe/modelo/usuario/Usuario.php';
include_once 'classe/modelo/usuario/Papel.php';
include_once 'Sessao.php';

 
// carregar conexao

// aguardar resposta, caso haja

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

  if( isset($_GET['all']) && $_SESSION['permissao']==0 )
      $objJson = $usuario->lerUsuarios($conexao);
  else
      $objJson = $usuario->lerUsuario($conexao);

  $objUsuario = $objJson ? json_decode($objJson) : null;


  $documento = new DocumentoAvaliacao;    
  $documentos = $documento->visualizarDocumentos($conexao);


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
                <h6 class="m-0 font-weight-bold text-primary">Documentos</h6>
              </div>
                <div class="card-body">


<?php 

if($documentos){

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
        
          <h4 class="h3 mb-2 text-gray-800">Todos os documentos</h4>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
            </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>      
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Papel</th>
                      </tr>
                    </thead>
                    <tbody>
        
                    <?php

                      foreach ($documentos as $key => $value) {

                        $documento = json_decode($value);
                        print_r($documento);
                      
                      /*
                        echo "<tr>";
                        echo "<td><a href='index.php?dir=usuarios&cod_usuario=".$user->id."'>".$user->nome."</a></td>"; 
                        echo "<td>".$user->email."</td>"; 
                        echo "<td>".$user->nomePapel."</td>";
                        echo "</tr>"; 
                      */
                        
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