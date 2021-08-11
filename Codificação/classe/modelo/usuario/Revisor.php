<?php 

include_once 'Papel.php';
include_once __DIR__.'/../ideia/DocumentoAvaliacao.php';

class Revisor extends Papel{

    private $documento;

    public function salvarDocumentoAvaliacao($conexao = null){

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

    public function visualizarDocumentoAvaliacao($pdo = null, $ideia = null){

    }

    public function setDocumento($v){
        $this->documento = $v;
    }

    public function getDocumento(){
        return $this->documento;
    }
}