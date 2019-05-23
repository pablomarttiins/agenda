<?php
require_once '../include/config.php';

header('Content-Type: application/json');

$conexao = new conexao();
$con = $conexao->conecta();

$query = $con->prepare('SELECT * FROM TB_Medico WHERE Excluido = 0 ORDER BY Nome');
$query->execute();
$res = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode((object) $res);