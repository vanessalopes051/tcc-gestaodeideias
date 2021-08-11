<?php

class Conexao {
	private $conn;

    public function obterConexao(){

        $this->conn = null;
   
        try{
            $this->conn = new PDO("mysql:host=localhost;dbname=gestao_ideias", "root", "");
		    // set the PDO error mode to exception
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function fecharConexao(){
        $this->conn = null;
    }

}

$pdo = new Conexao();
$conexao = $pdo->obterConexao();



/*
<?php

class Conexao {
    private $conn;

    public function obterConexao(){

        $this->conn = null;
   
        try{
            $this->conn = new PDO("mysql:host=amysql.gideias.net;dbname=gestao_ideias", "gideias", "f0r_40_pcS-f4@K");
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function fecharConexao(){
        $this->conn = null;
    }

}

$pdo = new Conexao();
$conexao = $pdo->obterConexao();


*/