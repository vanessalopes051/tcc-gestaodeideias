<?php 
  include_once 'classe/modelo/ideia/DocumentoAvaliacao.php';
  include_once 'classe/modelo/ideia/Ideia.php';
  include_once 'classe/banco/Conexao.php';
  include_once 'classe/controle/Mensagem.php';
  include_once 'Sessao.php';

 $sessao->iniciar();

 // verificação de usuario 
if($_SESSION['permissao'] != 2){
  if ($_SESSION['permissao'] != 0) {
      include_once 'telas/404.php';
      die();
  }
}



//
if(isset($_GET['edit']) || isset($_GET['sucesso']) || isset($_GET['err'])){


  // esperar resposta de Avaliacao
  if(isset($_GET['sucesso'])) {
    echo Mensagem::Error("Operação realizada!");
    $codIdeia = filter_input(INPUT_GET, 'sucesso', FILTER_VALIDATE_INT);
  }else if(isset($_GET['err'])){
    echo Mensagem::Error("Operação não realizada: Erro no banco de dados!");
    $codIdeia = filter_input(INPUT_GET, 'err', FILTER_VALIDATE_INT);
  }else {
    $codIdeia = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
  }

  
  if ($codIdeia == null && $codIdeia == 0 && $codIdeia == ''){
    include_once 'telas/404.php';
    die();
  }

  //
  $ideia = new Ideia();
  $ideia->setId($codIdeia);
  $objIdeia = $ideia->visualizarIdeia($conexao);

  //verificação do estado
  if(!$objIdeia){
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
                <h6 class="m-0 font-weight-bold text-primary">Editar </h6>
              </div>
                <div class="card-body">
                   
                <!-- Formulário de NOVA IDEIA -->
                <form action="./classe/post/EditarIdeia.php" method="post">

                <!-- TOKEN USER -->
                 <input type='hidden' class='form-control' name='token' value='<?php echo $_SESSION['token'] ?>'>
                <input type='hidden' class='form-control' name='id' value='<?php echo $codIdeia; ?>'>


                  <div class="form-group">
                      <label for="titulo" class="col-form-label">Título:</label>
                      <input type="text" class="form-control" name="titulo" id="titulo" value='<?php echo $objIdeia->getTitulo();?>' >
                  </div>

                  <div class="form-group">
                      <label for="descricao" class="col-form-label">Descrição:</label>
                      <textarea class="form-control" name="descricao" id="descricao"><?php echo $objIdeia->getDescricao(); ?></textarea>
                  </div>

                  <div class="form-group">
                      <label for="link" class="col-form-label">Endereço do Link:</label>
                      <input type="text" class="form-control" name="link" id="link" value='<?php echo $objIdeia->getLink(); ?>' >
                  </div>

                  <div class="modal-footer">
                      <input type="submit" value="Enviar Ideia" class="btn btn-primary">
                      <button type="button"><a href='index.php?dir=ideiasAdmin'>voltar</a>  </button>
                  </div>
                </form>

      
              </div>
            </div>
            <!-- /.container-fluid -->



<?php
}else {


  $ideia = new Ideia();
  $ideias = $ideia->visualizarIdeias($conexao);

 
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
        
          <h4 class="h3 mb-2 text-gray-800">Gerenciar Ideias</h4>
          <p class="mb-4">Selecione uma ideia para fazer alterações</p>

            <!-- DataTales Example --> 
            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Buscar:</h6>


          <!--formulário de pesquisa e filtros -->
          <form action="" method="" onsubmit=" return false;">
            <div class="form-group input-group"> 
                    <input name="consulta" id="txt_consulta" placeholder="Consultar Nome ou Link" type="text" class="form-control">
              <a class="btn btn-default" ><i class="fa fa-fw fa-sync"></i> Limpar</a>
            </div>
          </form>


            </div>
              <div class="card-body">
                <div class="table-responsive">


                  <table id="tabela" class="table table-striped table-bordered" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr >
                        <th scope="col">Título</th>
                        <th scope="col">Link</th>
                        <th scope="col">Criação</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                      foreach ($ideias as $key => $value) {

                        $ideia = $value;
                        echo "<tr>";
                        echo "<td><a href='index.php?dir=ideiasAdmin&edit=".$ideia->getId()."'>".$ideia->getTitulo()."</a></td>";
                        echo "<td> <a href='".$ideia->getLink()."' target='_blank'>".$ideia->getLink()."</a></td>";
                        echo "<td>".$ideia->getCriacao()."</td>"; 
                        echo "</tr>";

                      }

                    ?>
                    </tbody>
                  </table>

                <script> 
                  $('input#txt_consulta').quicksearch('table#tabela tbody tr');
                </script>

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
        
          <h4 class="h3 mb-2 text-gray-800">Opções</h4>
          <p class="mb-4">Selecione uma ideia para fazer uma nova avaliação!</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pendentes</h6>
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


<script  src="vendor/js/paginacao.js"></script>