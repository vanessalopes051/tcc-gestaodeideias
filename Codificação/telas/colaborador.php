<?php
include_once 'classe/banco/Conexao.php';
include_once 'classe/modelo/ideia/Ideia.php';
require_once 'classe/modelo/usuario/Usuario.php';
require_once 'classe/modelo/usuario/Colaborador.php';
include_once 'Sessao.php';


$sessao->iniciar();

// verificação de usuario 
if($_SESSION['permissao'] != 3){
  if ($_SESSION['permissao'] != 0) {
      include_once 'telas/404.php';
      die();
  }
}

?>


<?php

//Objeto colaborador
$colaborador = new Colaborador();
$colaborador->setId($_SESSION['codigo']);

//Ideias do colaborador
$pendentes = $colaborador->visualizarIdeias($conexao);
$c_pendentes = is_array($pendentes) ? count($pendentes) : 0;    

//Ideias implementadas do colaborador 
$implementadas = $colaborador->ideiasImplementadas($conexao);
$c_implementadas = is_array($implementadas) ? count($implementadas) : 0; 

?> 


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard do Colaborador</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Todas as ideias aprovadas e executadas -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Lista de Ideias Implementadas</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><a href='index.php?implementadas=1'><?php echo $c_implementadas; ?></a></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-rocket fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Minhas ideias cadastradas -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Minhas Ideias</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><a href='index.php?sugestoes=1'><?php echo $c_pendentes; ?></a></div>
                  </div>
                </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- Cadastrar Nova Ideia-->
    <div class="col-xl-3 col-md-6 mb-4" data-toggle="modal" data-target="#exampleModal" href="#">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" >Cadastrar Nova Ideia</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300" data-toggle="modal" data-target="#exampleModal" href="#"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>   <!-- /Content Row -->



  <!-- MODAL DE CADASTRO DE IDEIA-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Nova Ideia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">

            <!-- Formulário de NOVA IDEIA -->
            <form action="./classe/post/RegistrarIdeia.php" method="post">

            <!-- TOKEN USER -->
			<input type='hidden' class='form-control' name='token' value='<?php echo $_SESSION['token'] ?>'>


              <div class="form-group">
                  <label for="titulo" class="col-form-label" style="color:black;">Título:</label>
                  <input type="text" class="form-control" name="titulo" id="titulo" required>
              </div>

              <div class="form-group">
                  <label for="descricao" class="col-form-label" style="color:black;">Descrição:</label>
                  <textarea class="form-control" name="descricao" id="descricao" required></textarea>
              </div>

              <div class="form-group">
                  <label for="link" class="col-form-label" style="color:black;">Endereço do Link:</label>
                  <input type="text" class="form-control" name="link" id="link">
              </div>

              <div class="modal-footer">
                  <input type="submit" value="Enviar Ideia" class="btn btn-primary">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              </div>
            </form>

        </div>  

      </div>
    </div>
  </div>


<!-- MOSTRAR IDEIAS IMPLEMENTADAS  -->

<?php

    if(isset($_GET['implementadas'])){
      imprimir($implementadas);
    }else if(isset($_GET['sugestoes'])){
      imprimir($pendentes);
    }

    function imprimir($obj = null, $param1 = null){
      if($obj){
         
 ?>


    <!-- TABELAS - LISTA DE IDEIAS INOVADORAS -->
    <!-- Divider -->

    <hr class="sidebar-divider d-none d- md-block">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading  -->

          <!-- <h1 class="h3 mb-2 text-gray-800">Sugestões de Ideias</h1> -->

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

              <div class="card-header py-3"></div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>

                      <tr>
                        <th>codigo</th>
                        <th>Título</th>
                        <th>Link</th>
                        <th>Criação</th>
                      </tr>
                    </thead>

                    <tbody>

                    <?php
                        foreach ($obj as $key => $value) {

                          $ideia = $value;
                          
                          echo "<tr>";
                          echo "<td>".$ideia->getId()."</td>";
                          echo "<td>".$ideia->getTitulo()."</td>";
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
           
        }     
    }

?>


<!-- ./MOSTRAR IDEIAS IMPLEMENTADAS -->

