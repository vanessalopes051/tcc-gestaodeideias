<?php 
include_once 'telas/cabecalho.php'; 
  
// Sem verificação de permissão inicial
if(isset($_GET['dir'])){
  if($_GET['dir'] == 'usuarios'){
    include_once 'telas/usuarios.php';
  }          
}

        // admin
        if ($_SESSION['permissao'] == 0) {
        
          if (isset($_GET['dir'])) {
            if($_GET['dir'] == 'avaliacao'){            
              include_once 'telas/avaliacao.php';            
            }else if($_GET['dir'] == 'plano'){  
              include_once 'telas/plano.php';            
            }else if($_GET['dir'] == 'documentos'){              
              include_once 'telas/documentos.php';              
            }else if($_GET['dir'] == 'colaborador'){
              include_once 'telas/colaborador.php';
            }else if($_GET['dir'] == 'viabilidade'){
              include_once 'telas/viabilidade.php';
            }else if($_GET['dir'] == 'selecionar'){
              include_once 'telas/selecionar.php';
            }else if($_GET['dir'] == 'ideiasAdmin'){
              include_once 'telas/ideiasAdmin.php';
            }else if($_GET['dir'] == 'ideiasAdmin'){
              include_once 'telas/documentosAdmin.php';
            }else if($_GET['dir'] == 'empresa'){
              include_once 'telas/empresa.php';
            }
          }else {        
            include_once 'telas/admin.php';        
          }
        
        // revisao
        }else if(($_SESSION['permissao'] == 1)){
         
          if (isset($_GET['dir'])) {
            if($_GET['dir'] == 'viabilidade'){            
              include_once 'telas/viabilidade.php';            
            }else if($_GET['dir'] == 'documentos'){              
              include_once 'telas/documentos.php';              
            }
          }else {        
            include_once 'telas/revisao.php';        
          }          
        
        // eq. inovacao
        }else if(($_SESSION['permissao'] == 2)){

          if (isset($_GET['dir'])) {

            if($_GET['dir'] == 'avaliacao'){            
              include_once 'telas/avaliacao.php';            
            }else if($_GET['dir'] == 'plano'){  
              include_once 'telas/plano.php';            
            }else if($_GET['dir'] == 'documentos'){              
              include_once 'telas/documentos.php';              
            }

          }else {        
            include_once 'telas/equipe_inovacao.php';        
          }

         // colaborador
        }else if(($_SESSION['permissao'] == 3)){

          if (isset($_GET['dir'])) {
            if($_GET['dir'] == 'colaborador'){
              include_once 'telas/colaborador.php';
            }
          }else {
            include_once 'telas/colaborador.php';
          }
          
        // patrocinador
        }else if(($_SESSION['permissao'] == 4)){
          
          if (isset($_GET['dir'])) {
            if($_GET['dir'] == 'selecionar'){
              include_once 'telas/selecionar.php';
            }else if($_GET['dir'] == 'documentos'){              
              include_once 'telas/documentos.php';              
            }
          }else {
            include_once 'telas/patrocinador.php';
          }

        }   
          

  
  include_once 'telas/rodape.php'; 
  ?>