<?php 
 include_once 'classe/modelo/usuario/Inovacao.php';
  include_once 'classe/modelo/ideia/DocumentoAvaliacao.php';
  include_once 'classe/modelo/ideia/Ideia.php';
  include_once 'classe/banco/Conexao.php';
  include_once 'classe/controle/Mensagem.php';
  include_once 'Sessao.php';

  $sessao->iniciar();

// verificação de usuario 
if($_SESSION['permissao'] != 4){
  if ($_SESSION['permissao'] != 0) {
    include_once 'telas/404.php';
    die();
  }
}

  // esperar resposta de Avaliacao
  if (isset($_GET['r'])) {
    switch ($_GET['r']) {
    case 1:
      echo Mensagem::Sucesso("Resumo: Ideia inovadora Selecionada..");
      break;
    case 2:
      echo Mensagem::Sucesso("Erro: Você não preencheu todos os campos!");
      // no break
    default:
      echo Mensagem::Error("Operação não realizada!");
      break;
  }
}


if(isset($_GET['ideia'])){

  //
  $codIdeia = filter_input(INPUT_GET, 'ideia', FILTER_VALIDATE_INT);
  if ($codIdeia == null && $codIdeia == 0 && $codIdeia == ''){
    include_once 'telas/404.php';
    die();
  }

  //
  $ideia = new Ideia();
  $ideia->setId($codIdeia);
  $objIdeia = $ideia->visualizarIdeia($conexao);

  //verificação do estado
  if($objIdeia->getEstado()['cod'] != 4){
    include_once 'telas/404.php';
    die();
  }
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
                <h6 class="m-0 font-weight-bold text-primary">Seleção de Ideia</h6>
              </div>
                <div class="card-body">
                   
 
  <form name='documento' method='POST' action="classe/post/Selecionar.php">   

  <!-- TOKEN USER -->
<input type='hidden' class='form-control' name='token' value='<?php echo $_SESSION['token'] ?>'>


    <div class='form-group row'>
      <div class='col-sm-10'>
        <input type='hidden' class='form-control' name='ideia' value='<?php echo $codIdeia;?>'>  
        <input type='hidden' class='form-control' name='tipo' value='4'>                 
      </div>
    </div>

    <div class='form-group row'>
      <label for='' class='col-sm-2 col-form-label' style="color:black;">Título:</label>
      <div class='col-sm-10' style='color:black;'>
        <?php // print_r($objIdeia);
          echo $objIdeia->getTitulo();
        ?>                
      </div>
    </div>

    <div class='form-group row'>
      <label for='' class='col-sm-2 col-form-label' style="color:black;">Descrição:</label>
      <div class='col-sm-10' style='color:black;'>
        <?php // print_r($objIdeia);
          echo $objIdeia->getDescricao();
        ?>                
      </div>
    </div>

    <!-- AVALIAÇÕES FEITAS -->
    <div class='form-group row'>
      <label for='' class='col-sm-2 col-form-label' style="color:black;">Outras avaliações</label>
      <div class='col-sm-10'>
        
      <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th style='color:black;'>Tipo</th>
                        <th style='color:black;'>Link</th>
                        <th style='color:black;'>Revisor</th>
                        <th style='color:black;'>Criação</th>

                      </tr>
                    </thead>
                    <tbody>
        
                    <?php
                      // teste 
                      $documento = new DocumentoAvaliacao;
                      $documentos = $documento->visualizarDocumentosPorIdeia($conexao, $objIdeia->getId());

                      $documentosNulo = $documento->visualizarDocumentosPorIdeiaNulo($conexao, $objIdeia->getId());

                      if($documentosNulo){
                        foreach ($documentosNulo as $key => $value) {
                          array_push($documentos, $value);
                        }
                      }
                    
                      if ($documentos) {
                          foreach ($documentos as $key => $value) {
                              $doc = $value;
                              echo "<tr>";
                              echo "<td style='color:black;'>".$doc['tipo']."</td>";
                              echo "<td><a href='".$doc['linkDoc']."' target='_blank'>".$doc['linkDoc']."</a></td>";
                              echo "<td style='color:black;'>".$doc['usuario']."</td>";
                              echo "<td style='color:black;'>".$doc['criacao']."</td>";
                              echo "</tr>";
                          }
                      }else{
                        echo "<tr>Nenhuma avaliação realizada.</tr>";
                        
                      }
                      

                    ?>
        
                    </tbody>
                  </table>       
        

      </div>
    </div>
  </div>


    <div class='form-group row'>
      <label for='' class='col-sm-2 col-form-label' style="color:black;">Avaliações:</label>
      <div class='col-sm-10'>
        
        <select name='justificativa'>
          <option value='2'>Rejeitar</option>
          <option value='3'>Aceitar</option>          
        </select>

      </div>
    </div>

     <div class='form-group row'>
        <div class='col-sm-10'>
            <button type='submit'  class='btn btn-primary'>Enviar</button>
            <a href='index.php?dir=viabilidade'>voltar</a>                                
        </div>
      </div>
      
   </form>

                  </div>
                </div>
            <!-- /.container-fluid -->

<?php
}else {

  $ideia = new Ideia();
  $ideias = $ideia->visualizarIdeiasPorEstado($conexao, 4);
  
  if ($ideias) {
  
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
        
          <h4 class="h3 mb-2 text-gray-800">Ideias Viáveis</h4>
          <p class="mb-4">Selecione uma Ideia Inovadora!</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Buscar:</h6>


          <!--formulário de pesquisa e filtros -->
          <form action="" method="" onsubmit=" return false;">
            <div class="form-group input-group"> 
                    <input name="consulta" id="txt_consulta" placeholder="Consultar Ideias" type="text" class="form-control">
              <a class="btn btn-default" ><i class="fa fa-fw fa-sync"></i> Limpar</a>
            </div>
          </form>


            </div>
              
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Viáveis</h6>
            </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Link</th>
                        <th>Criação</th>
                      </tr>
                    </thead>
                    <tbody>
        
                    <?php

                      foreach ($ideias as $key => $value) {
                        $ideia = $value;
                        echo "<tr>";
                        echo "<td><a href='index.php?dir=selecionar&ideia=".$ideia->getId()."'>".$ideia->getTitulo()."</a></td>";
                        echo "<td> <a href='".$ideia->getLink()."' target='_blank'>".$ideia->getLink()."</a></td>";
                        echo "<td>".$ideia->getCriacao()."</td>"; 
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
        
          <h4 class="h3 mb-2 text-gray-800">Ideias viáveis</h4>
          <p class="mb-4">Selecione uma Ideia Inovadora!</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Viáveis</h6>
            </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Link</th>
                        <th>Criação</th>
                      </tr>
                    </thead>
                    <tbody>
        
                    <p class="mb-4">Nenhuma ideia foi encontrada!</p>
        
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        
          </div>
          <!-- /.container-fluid -->
<?php
  }
}
?>
 
