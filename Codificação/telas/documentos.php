<?php 
 include_once 'classe/modelo/usuario/Inovacao.php';
  include_once 'classe/modelo/ideia/DocumentoAvaliacao.php';
  include_once 'classe/modelo/ideia/Ideia.php';
  include_once 'classe/banco/Conexao.php';
  include_once 'classe/controle/Mensagem.php';
  include_once 'Sessao.php';

 $sessao->iniciar();

  // verificação de usuario 
  switch ($_SESSION['permissao']) {
    case 4:
    case 1:
    case 2:
    case 0:
      break;  
    default:
      include_once 'telas/404.php';
      die();
      break;
  }

    
  // carregar variavel ideia estado
  if(isset($_GET['ideia'])){
   // $codIdeia = preg_replace('/\D/', '', $_GET['ideia']);
    $codIdeia = filter_input(INPUT_GET, 'ideia', FILTER_VALIDATE_INT);

    if (!$codIdeia){
      include_once 'telas/404.php';
      die();
    }

    $documento = new DocumentoAvaliacao;
    
    $documentos = $documento->visualizarDocumentosPorIdeia($conexao, $codIdeia);
    $documentosNulos = $documento->visualizarDocumentosPorIdeiaNulo($conexao, $codIdeia);

    if ($documentosNulos) {
        foreach ($documentosNulos as $key => $value) {
            array_push($documentos, $value);
        }
    }

  }else{
  
    $documento = new DocumentoAvaliacao;
    $documentos = $documento->visualizarDocumentosPorUsuario($conexao, $_SESSION['codigo']);
    $documentosNulos = $documento->visualizarDocumentosPorUsuarioNulo($conexao, $_SESSION['codigo']);

    if ($documentosNulos) {
        foreach ($documentosNulos as $key => $value) {
          array_push($documentos, $value);
        }
    }

  }

  if ($documentos) {
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
        
          <h4 class="h3 mb-2 text-gray-800">Documentos cadastrados</h4>
          <!--<p class="mb-4">Documentos que você cadastrou.</p>-->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Buscar:</h6>


          <!--formulário de pesquisa e filtros -->
          <form action="" method="" onsubmit=" return false;">
            <div class="form-group input-group"> 
                    <input name="consulta" id="txt_consulta" placeholder="Consultar Documentos" type="text" class="form-control">
              <a class="btn btn-default" ><i class="fa fa-fw fa-sync"></i> Limpar</a>
            </div>
          </form>


            </div>

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Andamento</h6>
            </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>		
                        <th>Usuário</th>
                        <th>Ideia</th>
                        <th>Tipo</th>
                        <th>Justificativa</th>
                        <th>Link</th>
                        <th>Criação</th>
                      </tr>
                    </thead>
                    <tbody>
        
                    <?php

                      foreach ($documentos as $key => $value) {
                        $doc = $value;//json_decode($value);

                        $justf = isset($doc['justificativa']) ? $doc['justificativa'] : "-";

                        echo "<tr>";
                        echo "<td>".$doc['usuario']."</td>"; 
                        echo "<td>".$doc['codIdeia']."</td>"; 
                        echo "<td>".$doc['tipo']."</td>";
                        echo "<td>". $justf ."</td>";
                        echo "<td><a href='".$doc['linkDoc']."'>".$doc['linkDoc']."</a></td>";
                        echo "<td>".$doc['criacao']."</td>"; 
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
        

<?php
  }else{
?>
           <!-- Content Wrapper -->
           <div id="content-wrapper" class="d-flex flex-column">
        
        <!-- Main Content -->
        <div id="content">
        
          <!-- Begin Page Content -->
          <div class="container-fluid">
        
          <h4 class="h3 mb-2 text-gray-800">Documentos cadastrados</h4>
          <!--<p class="mb-4">Documentos que você cadastrou.</p>-->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Andamento</h6>
            </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Usuário</th>
                        <th>Ideia</th>
                        <th>Tipo</th>
                        <th>Justificativa</th>
                        <th>Link</th>
                        <th>Criação</th>
                      </tr>
                    </thead>
                    <tbody>
        
                    <p class="mb-4">Nenhum documento foi encontrado!</p>
        
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        
          </div>
          <!-- /.container-fluid -->
<?php
  }
?>
 
