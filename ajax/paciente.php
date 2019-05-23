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
    $query = $con->prepare('CALL STP_S_Paciente(:IDPaciente)');
    $query->bindValue(':IDPaciente', $_POST['IDPaciente']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    echo json_encode($res);
}

if($_GET['option'] == 'insert'){
	$query = $con->prepare('CALL STP_I_Paciente(:Nome, :Telefone, :Email, :CEP, :Rua, :Numero, :Bairro, :Cidade, :UF, :Complemento)');
	$query->bindValue(':Nome', $_POST['Nome']);
	$query->bindValue(':Telefone', $_POST['Telefone']);
	$query->bindValue(':Email', $_POST['Email']);
	$query->bindValue(':CEP', $_POST['CEP']);
	$query->bindValue(':Rua', $_POST['Rua']);
	$query->bindValue(':Numero', $_POST['Numero']);
	$query->bindValue(':Bairro', $_POST['Bairro']);
	$query->bindValue(':Cidade', $_POST['Cidade']);
	$query->bindValue(':UF', $_POST['Estado']);
	$query->bindValue(':Complemento', $_POST['Complemento']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}

if($_GET['option'] == 'update'){
	$query = $con->prepare('CALL STP_U_Paciente(:IDPaciente, :Nome, :Telefone, :Email, :CEP, :Rua, :Numero, :Bairro, :Cidade, :UF, :Complemento)');
	$query->bindValue(':IDPaciente', $_POST['IDPaciente']);
	$query->bindValue(':Nome', $_POST['Nome']);
	$query->bindValue(':Telefone', $_POST['Telefone']);
	$query->bindValue(':Email', $_POST['Email']);
	$query->bindValue(':CEP', $_POST['CEP']);
	$query->bindValue(':Rua', $_POST['Rua']);
	$query->bindValue(':Numero', $_POST['Numero']);
	$query->bindValue(':Bairro', $_POST['Bairro']);
	$query->bindValue(':Cidade', $_POST['Cidade']);
	$query->bindValue(':UF', $_POST['Estado']);
	$query->bindValue(':Complemento', $_POST['Complemento']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}

if($_GET['option'] == 'delete'){
	$query = $con->prepare('CALL STP_D_Paciente(:IDPaciente)');
	$query->bindValue(':IDPaciente', $_POST['IDPaciente']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}