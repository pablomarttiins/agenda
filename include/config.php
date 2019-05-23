<?php

/*------------------------- SITE -------------------------*/
$nome_site = 'Agenda';
$url_site = '';//SEM BARRA NO FINAL

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

class conexao{

	private static $host = 'sql137.main-hosting.eu; port=3306';
	private static $db = 'u942380273_sis2';
	private static $usuario = 'u942380273_sis2';
	private static $senha = 'BwjoLeh9JGKs';
	private static $con;

	public function conecta(){
		try{
			self::$con = new PDO('mysql:host='.self::$host.'; dbname='.self::$db, self::$usuario, self::$senha);
			self::$con->exec('SET CHARACTER SET utf8');
			self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//HABILITA EXIBIÇÃO DE ERROS DA CONEXÃO
			self::$con->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);//HABILITA EXIBIÇÃO DE ERROS DA CONEXÃO
			return self::$con;
		}
		catch(PDOException $e){
			echo 'ERRO: ' . $e->getMessage();
		}
	}

	public function injection($string){
		return addslashes($string);
	}

	public function injection_paginacao($string){
		return preg_replace("/[^0-9]/", '', $string);
	}
}

class autenticacao{

	public function cria_sessao($usuario, $senha){
		$conexao = new conexao();
		$con = $conexao->conecta();

		$usuario = $conexao->injection($usuario);//TRATAMENTO DO POST
		$senha = $conexao->injection($senha);//TRATAMENTO DO POST
		$senha = md5($senha); //CRIPTOGRAFA A SENHA


		$query = $con->prepare('SELECT IDUsuario, Nome, COUNT(*) AS Quantidade FROM TB_Usuario WHERE Usuario = :usuario AND Senha = :senha');
		$query->bindParam(':usuario', $usuario);
		$query->bindParam(':senha', $senha);
		$query->execute();
		$res = $query->fetch(PDO::FETCH_OBJ);

		if ($res->Quantidade == 1){
			session_start();
			$_SESSION['Usuario'] = $usuario;
			$_SESSION['Senha'] = $senha;
			$_SESSION['IDUsuario'] = $res->IDUsuario;
			$_SESSION['Nome'] = $res->Nome;
			return 'correto';
		}
		else
			return 'erro';
	}

	public function verifica_sessao($url){
		session_start();
		if(isset($_SESSION['Usuario']) && isset($_SESSION['Senha'])){
			$conexao = new conexao();
			$con = $conexao->conecta();

			//TRATA OS DADOS
			$usuario = $conexao->injection($_SESSION['Usuario']);
			$senha = $conexao->injection($_SESSION['Senha']);

			//VERIFICA NO BANCO
			$query = $con->prepare('SELECT COUNT(*) AS Quantidade FROM TB_Usuario WHERE Usuario = :usuario AND Senha = :senha');
			$query->bindParam(':usuario', $usuario);
			$query->bindParam(':senha', $senha);
			$query->execute();
			$res = $query->fetch(PDO::FETCH_OBJ);

			//SE AS CREDENCIAS NÃO AUTENTICAREM
			if($res->Quantidade == 0)
				$this->encerra_sessao();

			//NÃO DEIXA ACESSAR A PÁGINA DE LOGIN, PORQUÊ JÁ ESTÁ LOGADO
			if($url == 'login.php'){
				header('location: index.php');
				exit;
			}
		}
		//CASO NÃO EXISTIR SESSÃO
		elseif($url != 'login.php')
			$this->encerra_sessao();
	}

	public function encerra_sessao(){
		session_destroy();
		header('location: login.php');
		exit;
	}
}