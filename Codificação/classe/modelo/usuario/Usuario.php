<?php 

include_once __DIR__.'/../ideia/Ideia.php';
include_once 'Papel.php';

class Usuario {

	private $id;
    private $nome;
    private $foto;
    private $email;
	private $senha;
	private $papel;
	private $conta;
	private $ideia;	

	public function adicionarUsuario($conexao = null){

		$query = "INSERT INTO `USUARIO`(`NOME`, `FOTO`, `EMAIL`, `SENHA`, `COD_PAPEL`) 
				VALUES (?,NULL,?,md5(?),?)";

		$stmt = $conexao->prepare($query);

		$nome = htmlspecialchars(strip_tags($this->nome));
		//$foto = htmlspecialchars(strip_tags($this->foto));
		$email = htmlspecialchars(strip_tags($this->email));
		$senha = htmlspecialchars(strip_tags($this->senha));
		$papel = htmlspecialchars(strip_tags($this->papel));
		$stmt->bindParam(1, $nome);
		//$stmt->bindParam(2, $foto);
		$stmt->bindParam(2, $email);
		$stmt->bindParam(3, $senha);
		$stmt->bindParam(4, $papel);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
        }
        
		return true;
	}

	public function editarUsuario($conexao = null){

		$query = "UPDATE USUARIO SET NOME=?, EMAIL=?, SENHA=?, COD_PAPEL=? WHERE ID = ?";

		$stmt = $conexao->prepare($query);

		$id    = htmlspecialchars(strip_tags($this->id));
		$nome  = htmlspecialchars(strip_tags($this->nome));
		$email = htmlspecialchars(strip_tags($this->email));
		$senha = htmlspecialchars(strip_tags($this->senha));
		$papel = htmlspecialchars(strip_tags($this->papel));

		$stmt->bindParam(1, $nome);
		$stmt->bindParam(2, $email);
		$stmt->bindParam(3, $senha);
		$stmt->bindParam(4, $papel);
		$stmt->bindParam(5, $id);


		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
        }
        
		return true;
	}

	public function lerUsuarios($conexao = null){

		$query = "SELECT  U.`ID` as id, U.`NOME` as nome, U.`FOTO` as foto, U.`EMAIL` as email,
		 U.`CONTA` as conta, U.`CRIACAO` as criacao, U.`COD_PAPEL` as papel, P.NOME as nomePapel, U.SENHA as senha FROM `USUARIO` as U, PAPEL as P WHERE (P.ID=U.COD_PAPEL)";

		$stmt = $conexao->prepare($query);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}
		
		$usuarios = null;

		if($stmt->rowCount()){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$usuarios[] = json_encode($row);
			}
		}

		return json_encode($usuarios);
	}

	public function lerUsuario($conexao = null){

		$query = "SELECT  U.`ID` as id, U.`NOME` as nome, U.`FOTO` as foto, U.`EMAIL` as email,
		 U.`CONTA` as conta, U.`CRIACAO` as criacao, U.`COD_PAPEL` as papel, P.NOME as nomePapel, U.SENHA as senha FROM `USUARIO` as U, PAPEL as P WHERE (U.ID = ?) and (P.ID=U.COD_PAPEL)";

		$stmt = $conexao->prepare($query);

		$stmt->bindParam(1, $this->id);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}
		
		$usuario = null;

		if($stmt->rowCount()){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$usuario = json_encode($row);
		}

		return $usuario;
	}

	public function verificarCredenciais($conn = null){

		//$query = "SELECT U.ID as id, U.NOME as nome, U.EMAIL as email, G.PERMISSAO as permissao, G.NOME as grupo_nome FROM USUARIO AS U, GRUPO AS G WHERE (U.SENHA = md5(?)) and (U.NOME = ?) and (U.COD_GRUPO = G.ID)"; 
		$query = "SELECT U.ID as id, U.NOME as nome, U.FOTO as foto, 
		U.EMAIL as email, U.CONTA AS conta, U.SENHA as senha,P.ID AS codPapel, 
		P.NOME as papel, P.PERMISSAO as permissao FROM USUARIO AS U, PAPEL AS P
		 WHERE (U.COD_PAPEL = P.ID) and (U.SENHA = md5(?)) and (U.EMAIL = ?)";

		$stmt = $conn->prepare($query);

		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->senha=htmlspecialchars(strip_tags($this->senha));
		
		$stmt->bindParam(1, $this->senha);
		$stmt->bindParam(2, $this->email);

		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
        }
		
		$array = Array(0=>false);

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$array = Array(0=>$row['id'], 1=>$row['nome'], 2=>$row['email'], 3=>$row['conta'], 4=>$row['permissao'], 5=> utf8_encode($row['papel']));

		return json_encode($array);
	}

	public function altualizarUsuario(){

	}

	public function desabilitarUsuario(){

	}

	public function habilitarUsuario(){

	}	


	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}


	public function getIdeia()
	{
		return $this->ideia;
	}

	public function setIdeia($ideia)
	{
		$this->ideia = $ideia;
	}

	public function getPapel()
	{
		return $this->papel;
	}

	public function setPapel($papel)
	{
		$this->papel = $papel;
	}

	public function getConta()
	{
		return $this->conta;
	}

	public function setConta($conta)
	{
		$this->conta = $conta;
	}
 
	public function getSenha()
	{
		return $this->senha;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

    public function getEmail()
    {
        return $this->email;
    }
 
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
}