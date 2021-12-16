<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Requisições</title>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script type="text/javascript" language="javascript">
		$(document).ready(function() {
			$('#listar-requisicao').DataTable({			
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "requisicao.php",
					"type": "POST"
				}
			});
		} );
		</script>
	</head>
	<body>
	
		<h1>Processos Pendentes</h1>
		<table id="listar-requisicao" class="display" style="width:100%">
			<thead>
				<tr>
					<th>Numero</th>
					<th>Nome</th>
					<th>CPF</th>
					<th>Data</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<td><button type="button" class="btn btn-secondary">Fechar</button></td>
			</tbody>
		</table>

		<h1>Processos Avaliados</h1>
		<table class="table">
		<thead>
			<tr>
			<th scope="col">Numero</th>
			<th scope="col">Nome</th>
			<th scope="col">CPF</th>
			<th scope="col">Data</th>
			<th scope="col">Opções</th>
			</tr>
		</thead>

		<?php
		
		$pdo = new PDO('mysql:host=localhost; dbname=testegtrigueiro;', 'root', '');
		$limite_resultado = 50;
		$query_avaliados = "SELECT processo.numero, usuario.iduser, usuario.nome, usuario.cpf, requisicao.data , requisicao.idrequisicao, requisicao.justificativa, requisicao.avaliado FROM requisicao, processo, usuario WHERE requisicao.usuariofk = usuario.iduser AND requisicao.processofk = processo.idproc AND requisicao.avaliado = 1 ORDER BY requisicao.data DESC LIMIT $limite_resultado";
		$result_avaliados = $pdo->prepare($query_avaliados);
        $result_avaliados->execute();
		while ($row = $result_avaliados->fetch(PDO::FETCH_ASSOC)) {
		#	$query_avaliacao = "SELECT avaliacao.ticket, usuario.nome, avaliacao.justificativaaval, avaliacao.dataaval FROM avaliacao, usuario WHERE  avaliacao.requisicaofk = $row[idrequisicao] AND avaliacao.usuariofk = $row[iduser]";
		#	$result_avaliacao = $pdo->prepare($query_avaliados);
		#	$result_avaliacao->execute();

			echo '<tr>';
			echo '<td>' . $row["numero"] . '</td>';
			echo '<td>' . $row["nome"] . '</td> ';
			echo '<td>' . $row["cpf"] . '</td>';
			echo '<td>' . $row["data"] . '</td>';
			echo '<td> 
			
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
			Abrir
			</button>

			<!-- Modal -->
			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Avaliação</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				Nome: ' . $row["nome"] . '<br>
				Justificativa: ' . $row["justificativa"] . '<br>
				Data: ' . $row["data"] . '
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
				</div>
				</div>
			</div>
			</div>
			
			
			</td>';
			echo '</tr>';
		}

		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\SMTP;
		use PHPMailer\PHPMailer\Exception;

		//Load Composer's autoloader
		require './vendor/autoload.php';

		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.mailtrap.io';                    //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'dfec4b9c6df51d';                     //SMTP username
			$mail->Password   = 'd1812fa8517d0e';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		
			//Recipients
			$mail->setFrom('idema@example.com', 'Mailer');
			$mail->addAddress('joao@example.net', 'Joe User');
		
		/*	if($row["avaliado"]){
				$tipo = "aceito";
			}else{
				$tipo = "recusado, ". $row["justificativa"]. "";
			}*/
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Requisição avaliada';
			$mail->Body    = 'Ola';
		#	$mail->Body    = 'Ola'. $row["nome"] .' sua requisicão foi avaliada e '. $tipo .'</b>';
			$mail->AltBody = 'Ola';
		#	$mail->AltBody = 'Ola'. $row["nome"] .' sua requisicão foi avaliada e '. $tipo .'\n';
		
			$mail->send();


			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
			



		?>
		</table>


	</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>