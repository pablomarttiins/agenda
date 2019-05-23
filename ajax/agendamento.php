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
    $query = $con->prepare('CALL STP_S_Agendamento(:IDAgendamento)');
    $query->bindValue(':IDAgendamento', $_POST['IDAgendamento']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    echo json_encode($res);
}
if($_GET['option'] == 'insert'){
	$query = $con->prepare('CALL STP_I_Agendamento(:IDUsuario, :IDMedico, :IDPaciente, :Data, :Hora)');
	$query->bindValue(':IDUsuario', $_SESSION['IDUsuario']);
    $query->bindValue(':IDMedico', $_POST['IDMedico']);
    $query->bindValue(':IDPaciente', $_POST['IDPaciente']);
    $query->bindValue(':Data', $_POST['Data']);
    $query->bindValue(':Hora', $_POST['Hora']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}
if($_GET['option'] == 'update'){
	$query = $con->prepare('CALL STP_U_Agendamento(:IDAgendamento, :IDUsuario, :IDMedico, :IDPaciente, :Data, :Hora)');
	$query->bindValue(':IDAgendamento', $_POST['IDAgendamento']);
	$query->bindValue(':IDUsuario', $_SESSION['IDUsuario']);
    $query->bindValue(':IDMedico', $_POST['IDMedico']);
    $query->bindValue(':IDPaciente', $_POST['IDPaciente']);
    $query->bindValue(':Data', $_POST['Data']);
    $query->bindValue(':Hora', $_POST['Hora']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}
if($_GET['option'] == 'delete'){
	$query = $con->prepare('CALL STP_D_Agendamento(:IDAgendamento)');
	$query->bindValue(':IDAgendamento', $_POST['IDAgendamento']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}