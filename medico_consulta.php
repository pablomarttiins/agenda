<?php

require_once 'include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'paciente';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Sistema Administrativo</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0'>
	<!-- Main CSS-->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!-- Font-icon css-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Favicon -->
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<!-- Page specific css -->
	<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
</head>
<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-title-w-btn">
						<h3 class="title"><i class="fa fa-list"></i> Medico</h3>
						<p>
							<a href="medico_cadastro.php" class="btn btn-primary icon-btn">
								<i class="fa fa-plus"></i> Novo Medico
							</a>
						</p>
					</div>
					<div class="tile-body">
						<table class="table table-hover table-bordered w-100" id="tabela">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Telefone</th>
									<th>CRM</th>
									<th width="10%">AÇÕES</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = $con->query('
									SELECT * FROM TB_Medico
								');
								while($res = $query->fetch(PDO::FETCH_OBJ)){ ?>
									<tr>
										<td class="align-middle"><?= $res->Nome ?></td>
										<td class="align-middle"><?= $res->Telefone ?></td>
										<td class="align-middle"><?= $res->CRM ?></td>
										<td class="align-middle text-center">
											<a href="medico_cadastro.php?IDMedico=<?= $res->IDMedico ?>" class="btn btn-primary" title="Editar Medico"><i class="fa fa-pencil fa-lg fa-fw mr-0"></i></a>
											<button class="btn btn-danger" title="Excluir Medico" onclick="deletaCategoria(<?= $res->IDMedico ?>)"><i class="fa fa-trash fa-lg fa-fw mr-0"></i></button>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- Essential javascripts for application to work-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<!-- The javascript plugin to display page loading on top-->
	<script src="js/plugins/pace.min.js"></script>
	<!-- Page specific javascripts-->
	<script type="text/javascript" src="js/plugins/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
	<script type="text/javascript">
		$('#tabela').DataTable({
			bPaginate: false,
			responsive: true,
			language:{
				url: 'js/plugins/datatables/traducao.json'
			}
		});

		function deletaCategoria(IDMedico){
			swal({
				title: 'Deletar este medico?',
				text: '',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Sim, deletar',
				cancelButtonText: 'Não, cancelar',
				closeOnConfirm: true,
				closeOnCancel: true
			}, function(isConfirm){
				if(isConfirm){
					$.post('ajax/medico.php?option=delete', {IDMedico: IDMedico})
						.done(function(){
							location.reload();
						});
				}
			});
		}
	</script>
</body>
</html>
