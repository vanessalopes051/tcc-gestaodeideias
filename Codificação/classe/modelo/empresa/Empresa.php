<?php

class Empresa {

	private $nome;
	private $modeloPlanoProjeto;
	private $modeloCheckList;
	private $modeloViabilidade;


	public function lerDados($conexao = null){

		$query = "SELECT `NOME`, `MODELO_PLANO_PROJETO`, `MODELO_CHECK_LIST`, `MODELO_VIABILIDADE` FROM `EMPRESA` WHERE 1";

		$stmt = $conexao->prepare($query);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

		return json_encode($empresa);

	}

	public function atualizarDados($conexao = null){

	}


	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getModeloPlanoProjeto(){
		return $this->modeloPlanoProjeto;
	}

	public function setModeloPlanoProjeto($modeloPlanoProjeto){
		$this->modeloPlanoProjeto = $modeloPlanoProjeto;
	}

	public function getModeloCheckList(){
		return $this->modeloCheckList;
	}

	public function setModeloCheckList($modeloCheckList){
		$this->modeloCheckList = $modeloCheckList;
	}

	public function getModeloViabilidade(){
		return $this->modeloViabilidade;
	}

	public function setModeloViabilidade($modeloViabilidade){
		$this->modeloViabilidade = $modeloViabilidade;
	}

}