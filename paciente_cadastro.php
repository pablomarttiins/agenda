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
</head>
<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-title-w-btn">
						<h3 class="title"><i class="fa fa-pencil"></i> Nova Categoria</h3>
						<p>
							<a href="paciente_consulta.php" class="btn btn-danger icon-btn">
								<i class="fa fa-ban"></i> Cancelar
							</a>
						</p>
					</div>
					<div class="tile-body">
						<form id="formCadastro">
							<div class="form-row">
								<div class="form-group col-12 col-md-6">
									<label for="Nome">NOME</label>
									<input type="text" name="Nome" id="Nome" class="form-control" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Telefone">TELEFONE</label>
									<input type="text" name="Telefone" id="Telefone" class="form-control mask-telefone" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Email">E-MAIL</label>
									<input type="email" name="Email" id="Email" class="form-control" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="CEP">CEP</label>
									<input type="text" name="CEP" id="CEP" class="form-control mask-cep" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Rua">RUA</label>
									<input type="text" name="Rua" id="Rua" class="form-control cep-logradouro" maxlength="50" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Numero">NÚMERO</label>
									<input type="text" name="Numero" id="Numero" class="form-control cep-numero mask-somente-numeros" maxlength="10" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Bairro">BAIRRO</label>
									<input type="text" name="Bairro" id="Bairro" class="form-control cep-bairro" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Cidade">CIDADE</label>
									<input type="text" name="Cidade" id="Cidade" class="form-control cep-cidade" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Estado">ESTADO</label>
									<select name="Estado" id="Estado" class="form-control" required="">
										<option value="AC">Acre</option>
										<option value="AL">Alagoas</option>
										<option value="AP">Amapá</option>
										<option value="AM">Amazonas</option>
										<option value="BA">Bahia</option>
										<option value="CE">Ceará</option>
										<option value="DF">Distrito Federal</option>
										<option value="ES">Espírito Santo</option>
										<option value="GO">Goiás</option>
										<option value="MA">Maranhão</option>
										<option value="MT">Mato Grosso</option>
										<option value="MS">Mato Grosso do Sul</option>
										<option value="MG">Minas Gerais</option>
										<option value="PA">Pará</option>
										<option value="PB">Paraíba</option>
										<option value="PR">Paraná</option>
										<option value="PE">Pernambuco</option>
										<option value="PI">Piauí</option>
										<option value="RJ">Rio de Janeiro</option>
										<option value="RN">Rio Grande do Norte</option>
										<option value="RS">Rio Grande do Sul</option>
										<option value="RO">Rondônia</option>
										<option value="RR">Roraima</option>
										<option value="SC">Santa Catarina</option>
										<option value="SP">São Paulo</option>
										<option value="SE">Sergipe</option>
										<option value="TO">Tocantins</option>
									</select>
								</div>
								<div class="form-group col-12 col-md-6">
									<label for="Complemento">COMPLEMENTO</label>
									<input type="text" name="Complemento" id="Complemento" class="form-control" maxlength="255">
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<button type="submit" name="salvar" id="salvar" class="btn btn-primary d-block mx-auto mt-3"><i class="fa fa-save"></i> SALVAR</button>
								</div>
							</div>
							<input type="hidden" name="IDPaciente" id="IDPaciente">
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
	<script src="js/plugins/jquery.mask.min.js"></script>
	<script src="js/plugins/cep.js"></script>
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
				
				var option = $('#IDPaciente').val() == '' ? 'insert' : 'update';

				$.post('ajax/paciente.php?option='+option, $(form).serialize())
					.done(function(response){
						window.location.href = 'paciente_consulta.php';
					});
			}
		});

		<?php if(isset($_GET['IDPaciente']) && !empty($_GET['IDPaciente'])){ ?>

			$.post('ajax/paciente.php?option=select', {IDPaciente: <?= $_GET['IDPaciente'] ?>})
				.done(function(response){
					response = JSON.parse(response);

					$('#IDPaciente').val(response.IDPaciente);
					$('#Nome').val(response.Nome);
					$('#Telefone').val(response.Telefone);
					$('#Email').val(response.Email);
					$('#CEP').val(response.CEP);
					$('#Rua').val(response.Rua);
					$('#Numero').val(response.Numero);
					$('#Bairro').val(response.Bairro);
					$('#Cidade').val(response.Cidade);
					$('#Estado').val(response.Estado);
					$('#Complemento').val(response.Complemento);
				});

		<?php } ?>

		$('#CEP').focusout(function(){
			pesquisacep($(this).val());
		});
		
	</script>

</body>
</html>
