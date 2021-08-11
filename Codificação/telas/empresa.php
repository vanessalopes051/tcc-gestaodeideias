 <?php 

include_once 'classe/modelo/ideia/Ideia.php';
include_once 'classe/banco/Conexao.php';
include_once 'classe/controle/Mensagem.php';
include_once 'classe/modelo/empresa/Empresa.php';
include_once 'Sessao.php';

$sessao->iniciar();


// carregar conexao


$empresa = new Empresa;
$dados = $empresa->lerDados($conexao);
$dados = json_decode($dados);

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
                <h6 class="m-0 font-weight-bold text-primary">Empresa</h6>
              </div>
                <div class="card-body">

<form action="" method="" onsubmit="return false">
                       
        <!-- TOKEN USER -->
		<input type='hidden' class='form-control' name='token' value='<?php echo md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']); ?>'>
        <!-- USER -->


                        <div class="col-4">
                            <div class="input-group">
                                <label class="label">Nome da Empresa ou Instituição</label>
                                <input class="input--style-4" type="text" id="nome" name="nome" required value='<?=$dados->NOME?>'  size="40" maxlength="50">

                            </div>
                        </div>
                        
                        <br>

                        <div class="col-4">
                            <div class="input-group">
                                <label class="label">Modelo Plano de Projeto</label>
                                <input class="input--style-4" type="modeloPlanoProjeto" id="modeloPlanoProjeto" name="modeloPlanoProjeto" required value='<?=$dados->MODELO_PLANO_PROJETO?>'  size="40" maxlength="50">
                                <a href="<?=$dados->MODELO_PLANO_PROJETO?>" target="_blank">Abrir</a>
                            </div>
                        </div>

                        <br>

                        <div class="col-4">
                            <div class="input-group">
                                <label class="label">Modelo Check List</label>
                                <input class="input--style-4" type="modeloCheckList" id="modeloCheckList" name="modeloCheckList" required value='<?=$dados->MODELO_CHECK_LIST?>'  size="40" maxlength="50">
                                <a href="<?=$dados->MODELO_CHECK_LIST?>" target="_blank">Abrir</a>
                            </div>
                        </div>
                        <br>

                        <div class="col-4">
                            <div class="input-group">
                                <label class="label">Modelo Viabilidade</label>
                                <input class="input--style-4" type="modeloPlanoProjeto" id="modeloPlanoProjeto" name="modeloPlanoProjeto" required value='<?=$dados
                                ->MODELO_VIABILIDADE?>'  size="40" maxlength="50">
                                <a href="<?=$dados
                                ->MODELO_VIABILIDADE?>" target="_blank">Abrir</a>
                            </div>
                        </div>

                        <br>
                               
                    
                    <div class="col-4">
                        <div class="input-group">
                          <!-- <button type='submit'  class='btn btn-primary'>Salvar</button> -->   <a class='btn btn-primary' href='index.php'>voltar</a>                                
                        </div>
                    </div>

</form>

</div>
</div>