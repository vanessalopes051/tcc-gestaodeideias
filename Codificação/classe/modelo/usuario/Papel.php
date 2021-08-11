<?php
include_once 'Usuario.php';

class Papel { 

    protected $id;
    private $nome;
    private $permissao;
    protected $usuario;
    

    public function lerPapel($conexao = null, $param = null){

        if($param){
            $query = "SELECT ID as id, NOME as nome, PERMISSAO as permissao FROM PAPEL WHERE ID = ?";  
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
        }else{
            $query = "SELECT ID as id, NOME as nome, PERMISSAO as permissao FROM PAPEL";
            $stmt = $conexao->prepare($query);
        }        

        try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
        }

        $papeis = null;

        if($param){
            if ($stmt->rowCount()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $papeis = json_encode($row);
            }
        }else{
            if($stmt->rowCount()){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $obj = Array('id'=>$row['id'], 'nome'=>utf8_encode($row['nome']), 'permissao'=>$row['permissao']);
                    // ID as id, NOME as nome, PERMISSAO as permissao
                    $papeis[] = json_encode($obj);
                }
            }
        }

        return $papeis;

    }

    public function setId($v){
        $this->id = $v;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario($usuario){
        return $this->usuario = $usuario;
    }

    public function setUsuarios($v){
        $this->usuario[] = $v;
    }

    public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getPermissao(){
		return $this->permissao;
	}

	public function setPermissao($permissao){
		$this->permissao = $permissao;
	}
}