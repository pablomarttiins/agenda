<?php
require_once '../include/config.php';
$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));
$conexao = new conexao();
$con = $conexao->conecta();
if(!isset($_GET['option']) || empty($_GET['option']))
    exit('GET option required');
    
if(!isset($_POST) || empty($_POST))
    exit('POST required');
if($_GET['option'] == 'select'){
    $query = $con->prepare('CALL STP_S_Usuario(:IDUsuario)');
    $query->bindValue(':IDUsuario', $_POST['IDUsuario']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    echo json_encode($res);
}
if($_GET['option'] == 'insert'){
	$query = $con->prepare('CALL STP_I_Usuario(:Nome, :Usuario, :Senha)');
	$query->bindValue(':Nome', $_POST['Nome']);
	$query->bindValue(':Usuario', $_POST['Usuario']);
	$query->bindValue(':Senha', md5($_POST['Senha']));
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}
if($_GET['option'] == 'update'){
	$query = $con->prepare('CALL STP_U_Usuario(:IDUsuario, :Nome, :Usuario, :Senha)');
	$query->bindValue(':IDUsuario', $_POST['IDUsuario']);
	$query->bindValue(':Nome', $_POST['Nome']);
	$query->bindValue(':Usuario', $_POST['Usuario']);
	$query->bindValue(':Senha', !empty($_POST['Senha']) ? md5($_POST['Senha']) : null);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}
if($_GET['option'] == 'delete'){
	$query = $con->prepare('CALL STP_D_Usuario(:IDUsuario)');
	$query->bindValue(':IDUsuario', $_POST['IDUsuario']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}