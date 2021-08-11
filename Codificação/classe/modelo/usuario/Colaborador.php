<?php

include_once 'Papel.php';


class Colaborador extends Papel {
    
    // Essa já funciona
    public function cadastrarNovaIdeia($conexao = null){

        $query = "INSERT INTO `IDEIA`(`TITULO`, `DESCRICAO`, `LINK`, `COD_USUARIO`) 
                    VALUES (?,?,?,?)";

        $stmt = $conexao->prepare($query);

		$titulo = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getTitulo()));
	    $descricao = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getDescricao()));
		$link = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getLink()));
		$usuario = htmlspecialchars(strip_tags($this->usuario->getId()));

        $stmt->bindParam(1, $titulo);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $link);
        $stmt->bindParam(4, $usuario);
        
        try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
        }
        
        return true;
    }


    //Visualizar as ideias de cada usuário (COLABORADOR)
    public function visualizarIdeias($conexao = null, $id_colaborador = null){


        $query = "SELECT i.ID as idIdeia, i.TITULO as titulo, i.DESCRICAO as descricao,
		i.LINK as link, i.CRIACAO as criacao, i.COD_USUARIO as codUsuario, i.COD_ESTADO as codEstado, e.TIPO as estado , u.NOME as nomeUsuario, u.EMAIL as emailUsuario
		FROM IDEIA AS i, USUARIO AS u, ESTADO AS e
		WHERE (i.COD_USUARIO = u.ID) and (u.ID = ?)  AND  (i.COD_ESTADO = e.CODIGO)  ORDER BY 1";
    
        $stmt = $conexao->prepare($query);
        
        $id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $id);      

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


	public function ideiasImplementadas($conexao = null){

		$query = "SELECT i.ID as idIdeia, i.TITULO as titulo, i.DESCRICAO as descricao,
		 i.LINK as link, i.CRIACAO as criacao, i.COD_USUARIO as codUsuario,
		  i.COD_ESTADO as codEstado, e.TIPO as estado , u.NOME as nomeUsuario, u.EMAIL as emailUsuario
		FROM IDEIA AS i, USUARIO AS u, ESTADO AS e
		WHERE (i.COD_USUARIO = u.ID) and (i.COD_ESTADO = e.CODIGO) and (e.CODIGO = 6)
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


    public function editarIdeia($conexao = null){

    	$query = "UPDATE `IDEIA` SET `TITULO`=?,`DESCRICAO`=?,`LINK`=? WHERE `ID`=?";

        $stmt = $conexao->prepare($query);
       
		$titulo = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getTitulo()));
	    $descricao = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getDescricao()));
		$link = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getLink()));
		$id = htmlspecialchars(strip_tags($this->usuario->getIdeia()->getId()));

        $stmt->bindParam(1, $titulo);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $link);
        $stmt->bindParam(4, $id);
        
        try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
        }
        
        return true;
    }


}

