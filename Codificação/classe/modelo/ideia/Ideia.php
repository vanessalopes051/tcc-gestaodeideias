<?php

include_once __DIR__.'/../usuario/Usuario.php';
include_once 'DocumentoAvaliacao.php';


class Ideia {

	private $id;
    private $titulo;
    private $descricao;
    private $link;
    private $criacao;
	private $estado;

	private $usuario;
	private $documentoAvaliacao;

    public function visualizarIdeias($conexao = null){

		$query = "SELECT i.ID as idIdeia, i.TITULO as titulo, i.DESCRICAO as descricao, 
		i.LINK as link, i.CRIACAO as criacao, i.COD_USUARIO as codUsuario, i.COD_ESTADO as codEstado, 
		e.TIPO as estado , u.NOME as nomeUsuario, u.EMAIL as emailUsuario
		FROM IDEIA AS i, USUARIO AS u, ESTADO AS e
		WHERE (i.COD_USUARIO = u.ID) and (i.COD_ESTADO = e.CODIGO)
		ORDER BY 1";


		$stmt = $conexao->prepare($query);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}


		$ideias = null;

		if($stmt->rowCount()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
						
				$ideia = new Ideia();
				$ideia->setId($row['idIdeia']);
				$ideia->setTitulo($row['titulo']);
				$ideia->setDescricao($row['descricao']);
				$ideia->setLink($row['link']);
				$ideia->setCriacao($row['criacao']);
				$estado = Array('cod'=>$row['codEstado'], 'estado'=>$row['estado']);
				$ideia->setEstado($estado);

				$usuario = new Usuario();
				$usuario->setId($row['codUsuario']);
				$usuario->setNome($row['nomeUsuario']);
				$usuario->setEmail($row['emailUsuario']);

				$usuario->setIdeia($ideia);
				$ideia->setUsuario($usuario);										
				
				// atribuição da ultima linha
				$ideias[] = $ideia;
			}

		}

		return $ideias;
	}

    public function visualizarIdeia($conexao = null){

		$query = "SELECT i.ID as idIdeia, i.TITULO as titulo, i.DESCRICAO as descricao, 
		i.LINK as link, i.CRIACAO as criacao, i.COD_USUARIO as codUsuario, 
		i.COD_ESTADO as codEstado, e.TIPO as estado , u.NOME as nomeUsuario, u.EMAIL as emailUsuario
		FROM IDEIA AS i, USUARIO AS u, ESTADO AS e
		WHERE (i.COD_USUARIO = u.ID) and (i.COD_ESTADO = e.CODIGO) and (i.ID = ?)
		ORDER BY 1";

		$stmt = $conexao->prepare($query);
		$stmt->bindParam(1, $this->id);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}


		$ideia = null;

		if($stmt->rowCount()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
						
				$ideia = new Ideia();
				$ideia->setId($row['idIdeia']);
				$ideia->setTitulo($row['titulo']);
				$ideia->setDescricao($row['descricao']);
				$ideia->setLink($row['link']);
				$ideia->setCriacao($row['criacao']);
				$estado = Array('cod'=>$row['codEstado'], 'estado'=>$row['estado']);
				$ideia->setEstado($estado);

				$usuario = new Usuario();
				$usuario->setId($row['codUsuario']);
				$usuario->setNome($row['nomeUsuario']);
				$usuario->setEmail($row['emailUsuario']);

				$usuario->setIdeia($ideia);
				$ideia->setUsuario($usuario);							

			}

		}

		return $ideia;
	}

	public function visualizarIdeiasPorEstado($conexao = null, $estado = null){

		$query = "SELECT i.ID as idIdeia, i.TITULO as titulo, i.DESCRICAO as descricao,
		 i.LINK as link, i.CRIACAO as criacao, i.COD_USUARIO as codUsuario,
		  i.COD_ESTADO as codEstado, e.TIPO as estado , u.NOME as nomeUsuario, u.EMAIL as emailUsuario
		FROM IDEIA AS i, USUARIO AS u, ESTADO AS e
		WHERE (i.COD_USUARIO = u.ID) and (i.COD_ESTADO = e.CODIGO) and (e.CODIGO = ?)
		ORDER BY 1";

		$stmt = $conexao->prepare($query);
		$estado = htmlspecialchars(strip_tags($estado));
		$stmt->bindParam(1, $estado);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}


		$ideias = null;

		if($stmt->rowCount()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
						
				$ideia = new Ideia();
				$ideia->setId($row['idIdeia']);
				$ideia->setTitulo($row['titulo']);
				$ideia->setDescricao($row['descricao']);
				$ideia->setLink($row['link']);
				$ideia->setCriacao($row['criacao']);
				$estado = Array('cod'=>$row['codEstado'], 'estado'=>$row['estado']);
				$ideia->setEstado($estado);

				$usuario = new Usuario();
				$usuario->setId($row['codUsuario']);
				$usuario->setNome($row['nomeUsuario']);
				$usuario->setEmail($row['emailUsuario']);

				$usuario->setIdeia($ideia);
				$ideia->setUsuario($usuario);										
				
				// atribuição da ultima linha
				$ideias[] = $ideia;
			}

		}

		return $ideias;
	}

	public function mudarEstado($conexao = null){

		// mudar estado e historico
		$query = "UPDATE `IDEIA` SET COD_ESTADO = ? WHERE ID = ?";
		$stmt = $conexao->prepare($query);

		$estado = htmlspecialchars(strip_tags($this->estado));
		$usuario =  htmlspecialchars(strip_tags($this->id));
		
		$stmt->bindParam(1, $estado);
		$stmt->bindParam(2, $usuario);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		return true;
	}



	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTitulo(){
		return $this->titulo;
	}

	public function setTitulo($titulo){
		$this->titulo = $titulo;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function getLink(){
		return $this->link;
	}

	public function setLink($link){
		$this->link = $link;
	}

	public function getCriacao(){
		return $this->criacao;
	}

	public function setCriacao($criacao){
		$this->criacao = $criacao;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}

	public function getDocumentoAvaliacao(){
		return $this->documentoAvaliacao;
	}

	public function setDocumentoAvaliacao($v){
		$this->documentoAvaliacao = $v;
	}
	
	public function setDocumentosAvaliacao($v){
		$this->documentoAvaliacao[] = $v;
	}

}