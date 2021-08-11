<?php 
require_once 'Autoload.php';
// obtendo arquivo
$autoload = new Autoload('classe/controle/');
header('Content-Type: text/html; charset=utf-8');
// definindo link geral
define("BASE_URL", "http://localhost/pi2");


class Sessao {

	private $elementos;

	function __construct($array){
		// para nomes de cookies de sessão diferentes 
		//session_name(rand(999,getrandmax()).$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		// iniciar nova sessao
		session_start();		
		$this->elementos = $array;

	}

	public function iniciar(){

	    if( (!isset($_SESSION['codigo'])   == true) && (!isset($_SESSION['nome']) == true) &&
			(!isset($_SESSION['email']) == true) && (!isset($_SESSION['conta']) == true)   && 
			(!isset($_SESSION['permissao']) == true)  &&  (!isset($_SESSION['papel']) == true)){
	        
	        foreach ($this->elementos as $key => $value) {
	        	unset($_SESSION[$value]);
			}
				       
	        session_destroy();
	        IrPara::link('/telas/login.php?e=1');
	    }

	}

	public function nova($array = null){

		if($array){
			$_SESSION['codigo']    = $array[0];
			$_SESSION['nome']      = $array[1];
			$_SESSION['email']     = $array[2];
			$_SESSION['conta']     = $array[3];
			$_SESSION['permissao'] = $array[4];
			$_SESSION['papel'] 	   = $array[5];
			$_SESSION['inicio']    = $array[6];
			$_SESSION['token']    = $array[7];

			//nome de sessão diferente para cada usuário
			//session_name(md5($_SESSION['nome'].$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));

			// configurações do cookie			
			//init_set('session.use_cookies', '1');
			//init_set('session.use_only_cookies', '1');
			//init_set('session.use_trans_sid', '0');            


 		}else{
			exit("Array não pode está vazio!");
		}

	}

	public function login(){
		if((isset($_SESSION['codigo']) == true) && (isset($_SESSION['nome']) == true) && 
		(isset($_SESSION['email']) == true) && (isset($_SESSION['conta']) == true) && 
		(isset($_SESSION['permissao']) == true) && (isset($_SESSION['papel']) == true) &&
		(isset($_SESSION['inicio']) == true) && (isset($_SESSION['token']) == true) ){
			IrPara::link("/index.php");
		}	
	}

	public function apagar($param = null){

		/*
		foreach ($this->$elementos as $key => $value) {
			unset($_SESSION[$value]);
		}
	   
		if($param){	
			session_destroy();
		}else{
			session_destroy();
			header(IrPara::link('/telas/login.php'));
		}
		*/
		session_destroy();
		IrPara::link('/telas/login.php');

	}
}
  
$array = Array(0 => 'codigo', 1 => 'nome', 2 => 'email', 3 => 'conta', 4 => 'permissao', 5 => 'papel', 6 => 'inicio', 7 => 'token');
$sessao = new Sessao($array);
