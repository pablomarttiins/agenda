<?php

require_once 'include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'agendamento';

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
</head>
<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-title-w-btn">
						<h3 class="title"><i class="fa fa-pencil"></i> Novo Agendamento</h3>
						<p>
							<a href="agendamento_consulta.php" class="btn btn-danger icon-btn">
								<i class="fa fa-ban"></i> Cancelar
							</a>
						</p>
					</div>
					<div class="tile-body">
						<form id="formCadastro">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="IDMedico">MÉDICO</label>
									<select name="IDMedico" id="IDMedico" class="form-control" required>
										<option value="" style="display: none;">Selecione aqui...</option>

										<?php
										$query = $con->query('
											SELECT 
												m.IDMedico,
												m.Nome
											FROM
												TB_Medico m
											WHERE
												m.Excluido = 0
											ORDER BY
												m.Nome
										');
										while($res = $query->fetch(PDO::FETCH_OBJ)){ ?>

											<option value="<?= $res->IDMedico ?>"><?= $res->Nome ?></option>

										<?php } ?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="IDPaciente">PACIENTE</label>
									<select name="IDPaciente" id="IDPaciente" class="form-control" required>
										<option value="" style="display: none;">Selecione aqui...</option>

										<?php
										$query = $con->query('
											SELECT 
												p.IDPaciente,
												p.Nome
											FROM
												TB_Paciente p
											WHERE
												p.Excluido = 0
											ORDER BY
												p.Nome
										');
										while($res = $query->fetch(PDO::FETCH_OBJ)){ ?>

											<option value="<?= $res->IDPaciente ?>"><?= $res->Nome ?></option>

										<?php } ?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="Data">DATA</label>
									<input type="Date" name="Data" id="Data" class="form-control" required>
								</div>
								<div class="form-group col-md-6">
									<label for="Hora">HORA</label>
									<input type="Time" name="Hora" id="Hora" class="form-control" required>
								</div>
								<div class="col-12">
									<button type="submit" name="salvar" id="salvar" class="btn btn-primary d-block mx-auto mt-3"><i class="fa fa-save"></i> SALVAR</button>
								</div>
							</div>
							<input type="hidden" name="IDAgendamento" id="IDAgendamento">
						</form>
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
	<script src="js/plugins/jquery.validate.js"></script>
	<script>
		$('#formCadastro').validate({
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			errorPlacement: function(){
				return false;//REMOVER MENSAGENS
			},
			submitHandler: function(form){
				$('#salvar').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> SALVANDO...').attr('disabled', '');
				var option = $('#IDAgendamento').val() == '' ? 'insert' : 'update';
				$.post('ajax/agendamento.php?option='+option, $(form).serialize())
					.done(function(response){
						window.location.href = 'agendamento_consulta.php';
					});
			}
		});
		<?php if(isset($_GET['IDAgendamento']) && !empty($_GET['IDAgendamento'])){ ?>
			$.post('ajax/agendamento.php?option=select', {IDAgendamento: <?= $_GET['IDAgendamento'] ?>})
				.done(function(response){
					response = JSON.parse(response);
					$('#IDAgendamento').val(response.IDAgendamento);
					$('#IDMedico').val(response.IDMedico);
					$('#IDPaciente').val(response.IDPaciente);
					$('#Data').val(response.Data);
					$('#Hora').val(response.Hora);
				});
		<?php } ?>
		
	</script>

</body>
</html>
