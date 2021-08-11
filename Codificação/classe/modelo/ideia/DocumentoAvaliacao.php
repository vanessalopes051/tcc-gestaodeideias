<?php 

include_once __DIR__.'/../usuario/Usuario.php';
include_once 'Ideia.php';

class DocumentoAvaliacao {

	private $id;
	private $link;
	private $criacao;
	private $tipo;
	private $justificativa;
	private $usuario;
	private $ideia;

	public function visualizarDocumentos($conexao = null){

		$query = "SELECT `ID` as id, `COD_USUARIO` as codUsuario, `COD_IDEIA` as codIdeia,
				 `COD_TIPO` as codTipo, `COD_JUSTIFICATIVA` codJustificativa, `LINK` as link,
				 `CRIACAO` as criacao FROM `DOCUMENTO_AVALIACAO`";

		$stmt = $conexao->prepare($query);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		$documentos = null;

		if($stmt->rowCount()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				$documentos[] = json_encode($row);

			}
		}

		return $documentos;
	}
 
	public function visualizarDocumentosPorUsuario($conexao = null, $usuario = null){

		$query = "SELECT  D.ID as idDoc, D.COD_USUARIO as codUsuario, U.NOME AS usuario , 
			D.COD_IDEIA as codIdeia, D.COD_TIPO as codTipo, T.TIPO AS tipo, D.COD_JUSTIFICATIVA as codJustificativa,
			J.TIPO as justificativa, D.LINK as linkDoc, D.CRIACAO as criacao 
			FROM DOCUMENTO_AVALIACAO AS D, TIPO AS T, JUSTIFICATIVA AS J, USUARIO AS U
			WHERE (D.COD_USUARIO = ?) AND (T.CODIGO = D.COD_TIPO) AND 
				  (J.CODIGO = D.COD_JUSTIFICATIVA) AND (D.COD_USUARIO = U.ID)";
				  
		$stmt = $conexao->prepare($query);

		$id = htmlspecialchars(strip_tags($usuario));
		$stmt->bindParam(1, $id);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		$documentos = null;

		if($stmt->rowCount()){

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$documentos[] = $row;
			}

		}		

		return $documentos;
	}

	public function visualizarDocumentosPorUsuarioNulo($conexao = null, $usuario = null){

		$query = "SELECT  D.ID as idDoc, D.COD_USUARIO as codUsuario, U.NOME AS usuario, D.COD_IDEIA as codIdeia, 
		D.COD_TIPO as codTipo, T.TIPO AS tipo, D.COD_JUSTIFICATIVA as codJustificativa, D.LINK as linkDoc, D.CRIACAO as criacao 
		FROM DOCUMENTO_AVALIACAO AS D, TIPO AS T, USUARIO AS U WHERE (D.COD_USUARIO = ?) AND (T.CODIGO = D.COD_TIPO) 
		AND (D.COD_USUARIO = U.ID) AND (D.COD_JUSTIFICATIVA IS NULL)";

		$stmt = $conexao->prepare($query);

		$id = htmlspecialchars(strip_tags($usuario));
		$stmt->bindParam(1, $id);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		$documentos = null;

		if($stmt->rowCount()){

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$documentos[] = $row;
			}

		}		

		return $documentos;
	}


	public function visualizarDocumentosPorIdeia($conexao = null, $codigo = null){

		$query = "SELECT  D.COD_IDEIA as codIdeia, D.ID as id, D.COD_USUARIO as codUsuario,
			U.NOME AS usuario , T.TIPO AS tipo, J.TIPO as justificativa, D.LINK as linkDoc, D.CRIACAO as criacao 
			FROM IDEIA AS I, DOCUMENTO_AVALIACAO AS D, TIPO AS T, JUSTIFICATIVA AS J, USUARIO AS U 
			WHERE (T.CODIGO = D.COD_TIPO) AND (I.ID = D.COD_IDEIA) AND (J.CODIGO = D.COD_JUSTIFICATIVA) AND (U.ID = D.COD_USUARIO) AND (D.COD_IDEIA = ?)";

		$stmt = $conexao->prepare($query);
		$stmt->bindParam(1, $codigo);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		$documentos = null;

		if($stmt->rowCount()){

			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
				extract($row);
				$documentos[] = $row;
			}

		}		

		return $documentos;

	}

	public function visualizarDocumentosPorIdeiaNulo($conexao = null, $codigo = null){

		$query = "SELECT  D.COD_IDEIA as codIdeia, D.ID as id, D.COD_USUARIO as codUsuario, U.NOME AS usuario , 
		T.TIPO AS tipo, D.LINK as linkDoc, D.COD_JUSTIFICATIVA as codJustificativa, D.CRIACAO as criacao FROM IDEIA AS I,
		 DOCUMENTO_AVALIACAO AS D, TIPO AS T, USUARIO AS U WHERE (T.CODIGO = D.COD_TIPO) AND (I.ID = D.COD_IDEIA) AND
		  (D.COD_JUSTIFICATIVA IS NULL) AND (U.ID = D.COD_USUARIO) AND (D.COD_IDEIA = ?)";

		$stmt = $conexao->prepare($query);
		$stmt->bindParam(1, $codigo);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}

		$documentos = null;

		if($stmt->rowCount()){

			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
				extract($row);
				$documentos[] = $row;
			}

		}		

		return $documentos;

	}


  	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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

	public function getAvaliacao(){
		return $this->avaliacao;
	}

	public function setAvaliacao($avaliacao){
		$this->avaliacao = $avaliacao;
	}

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
  }
  
  public function getIdeia(){
		return $this->ideia;
	}

	public function setIdeia($ideia){
		$this->ideia = $ideia;
	}

	public function setJustificativa($v){
		$this->justificativa = $v;
	}

	public function setTipo($v){
		$this->tipo = $v;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function getJustificativa(){
		return $this->justificativa;
	}
}



