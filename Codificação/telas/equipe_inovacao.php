<?php
  include_once 'Sessao.php';
  include_once 'Autoload.php';
  include_once 'classe/banco/Conexao.php';
  include_once 'classe/modelo/ideia/Ideia.php';
  $sessao->iniciar();

// verificação de usuario 
if($_SESSION['permissao'] != 2){
  if ($_SESSION['permissao'] != 0) {
    include_once 'telas/404.php';
    die();
  }
}

?>

<?php

//objeto ideia
$ideia = new Ideia();

// buscar ideias por estado
/* PENDENTES */
$pendentes = $ideia->visualizarIdeiasPorEstado($conexao, 1);
$c_pendentes = is_array($pendentes) ? count($pendentes) : 0;                       
/* EM ANDAMENTO */
$registrada  =  $ideia->visualizarIdeiasPorEstado($conexao, 3);
$viavel      = $ideia->visualizarIdeiasPorEstado($conexao, 4);
$preenchimento = $ideia->visualizarIdeiasPorEstado($conexao, 2);
$executando  = $ideia->visualizarIdeiasPorEstado($conexao, 5);
//verificação de array 
$countViavel = (is_array($viavel) ? count($viavel) : 0);
$countPreenchimento = (is_array($preenchimento) ? count($preenchimento) : 0);
$countExecutando = (is_array($executando) ? count($executando) : 0);
$countRegistrada = (is_array($registrada) ? count($registrada) : 0);

$andamento   = $countViavel + $countPreenchimento +  
                $countExecutando +  $countRegistrada;

/*  CANCELADA */
$cancelada = $ideia->visualizarIdeiasPorEstado($conexao, 7);
$c_cancelada = is_array($cancelada) ? count($cancelada) : 0; 
/* IMPLEMENTADAS */
$implementadas = $ideia->visualizarIdeiasPorEstado($conexao, 6);
$c_implementadas = is_array($implementadas) ? count($implementadas) : 0; 
?> 

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
           <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
          </div>

          <!-- Content Row -->
          <div class="row">


<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sugestões</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><a href='index.php?sugestoes=1'><?php echo $c_pendentes; ?></a></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-rocket fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Implementadas</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><a href='index.php?implementadas=1'><?php echo $c_implementadas; ?></a></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Em execução</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><a href='index.php?executando=1'><?php echo $andamento; ?></a></div>
                        </div>
                        <!--
                        <div class="col">
                          <div class="progress progress-sm mr-2">-->
                            <!--<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>-->
                        <!--  </div>
                        </div>-->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Reprovadas</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><a href='index.php?canceladas=1'><?php echo $c_cancelada; ?></a></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

         

<?php

    if(isset($_GET['sugestoes'])){
        imprimir($pendentes);
    }else if(isset($_GET['implementadas'])){
        imprimir($implementadas);
    }else if(isset($_GET['executando'])){
        imprimir($registrada);
        imprimir($viavel);
        imprimir($preenchimento);
        imprimir($executando);
    }else if(isset($_GET['canceladas'])){
        imprimir($cancelada);
    }

    function imprimir($obj = null, $param1 = null){
        if($obj){
         
 ?>


    <!-- Nav Item - Tables -->
       <!-- Divider -->
       <hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading
    <h1 class="h3 mb-2 text-gray-800">Sugestões de Ideias</h1>
 -->
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

      <!-- 


        -->

      </div>
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
                  $estado = $ideia->getEstado();
                 //\\\ print_r($estado);
                  
                  echo "<tr>";
                  echo "<td>".$ideia->getId()."</td>";
                  echo "<td><a href='index.php?dir=documentos&ideia=".$ideia->getId()."'>".$ideia->getTitulo()."</a></td>";
                  echo "<td> <a href='".$ideia->getLink()."' target='_blank'>".$ideia->getLink()."</a></td>";
                  echo "<td>".$ideia->getCriacao()."</td>";
                  echo $estado['cod']==5?"<td><a href='classe/post/FinalizarIdeia.php?ideia=".$ideia->getId()."'>Marcar Como Implementada</a></td>":'';
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

