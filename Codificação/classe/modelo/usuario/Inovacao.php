<?php
include_once 'Papel.php';
include_once __DIR__.'/../ideia/DocumentoAvaliacao.php';

class Inovacao extends Papel{

    private $documento;

    public function fazerAvaliacaoInicial($conexao = null){

        $query = "INSERT INTO `DOCUMENTO_AVALIACAO`(`COD_USUARIO`, `COD_IDEIA`, 
                                                    `COD_TIPO`, `COD_JUSTIFICATIVA`, `LINK`) 
                            VALUES (?,?,?,?,?)";
        
        $stmt = $conexao->prepare($query);

        $link = htmlspecialchars(strip_tags($this->documento->getLink()));
        $usuario = htmlspecialchars(strip_tags($this->documento->getUsuario()));
        $ideia = htmlspecialchars(strip_tags($this->documento->getIdeia()));
        $tipo = htmlspecialchars(strip_tags($this->documento->getTipo()));
        $justificativa = htmlspecialchars(strip_tags($this->documento->getJustificativa()));

        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $ideia);
        $stmt->bindParam(3, $tipo);
        $stmt->bindParam(4, $justificativa);
        $stmt->bindParam(5, $link);
        

        try{
            $stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }           
        
        return true;
    }

    public function salvarPlanoProjeto($conexao = null){

        $query = "INSERT INTO `DOCUMENTO_AVALIACAO`(`COD_USUARIO`, `COD_IDEIA`, 
                                                    `COD_TIPO`, `COD_JUSTIFICATIVA`, `LINK`) 
                            VALUES (?,?,?,?,?)";
        
        $stmt = $conexao->prepare($query);

        $link = htmlspecialchars(strip_tags($this->documento->getLink()));
        $usuario = htmlspecialchars(strip_tags($this->documento->getUsuario()));
        $ideia = htmlspecialchars(strip_tags($this->documento->getIdeia()));
        $tipo = htmlspecialchars(strip_tags($this->documento->getTipo()));
        $justificativa = null; //htmlspecialchars(strip_tags($this->documento->getJustificativa()));

        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $ideia);
        $stmt->bindParam(3, $tipo);
        $stmt->bindParam(4, $justificativa);
        $stmt->bindParam(5, $link);
        

        try{
            $stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }           
        
        return true;
    }

    public function finalizarIdeia($conexao = null){

        $query = "UPDATE `IDEIA` SET COD_ESTADO=6 WHERE ID=?";

        $stmt = $conexao->prepare($query);
        $ideia = $this->usuario->getIdeia()->getId();

        $stmt->bindParam(1, $ideia);

        try{
            $stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }           
        
        return true;
    }

    public function registrarIdeia(){


    }

    public function visualizarListaIdeiasInovadoras(){

        
    }

    public function visualizarDocumentos($conexao = null){

		$query = "SELECT  D.ID as id, D.COD_USUARIO as codUsuario, D.COD_IDEIA as codIdeia, D.COD_TIPO as codTipo, T.TIPO AS tipo, D.COD_JUSTIFICATIVA as codJustificativa, D.LINK as link, D.CRIACAO as criacao
                FROM DOCUMENTO_AVALIACAO AS D, TIPO AS T  WHERE (D.COD_USUARIO = ?) AND (D.COD_TIPO = T.CODIGO)";

		$stmt = $conexao->prepare($query);
		$stmt->bindParam(1, $this->id);

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

    public function setDocumento($v){
        $this->documento = $v;
    }

    public function getDocumento(){
        return $this->documento;
    }

}
