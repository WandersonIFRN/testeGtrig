<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testegtrigueiro";

$conn = mysqli_connect($servername, $username, $password, $dbname);

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;


//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'numero', 
	1 => 'nome',
	2=> 'cpf',
	3=> 'data',
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT processo.numero, usuario.nome, usuario.cpf, requisicao.data, requisicao.idrequisicao FROM requisicao, processo, usuario WHERE requisicao.usuariofk = usuario.iduser AND requisicao.processofk = processo.idproc AND requisicao.avaliado = 0";
$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT processo.numero, usuario.nome, usuario.cpf, requisicao.data, requisicao.justificativa, requisicao.idrequisicao FROM requisicao, processo, usuario WHERE 1=1 AND requisicao.usuariofk = usuario.iduser AND requisicao.processofk = processo.idproc AND requisicao.avaliado = 0";
if( !empty($requestData['search']['value']) ) {
	$result_usuarios.=" AND ( nome LIKE '".$requestData['search']['value']."%' ";    
	$result_usuarios.=" OR email LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR cpf LIKE '".$requestData['search']['value']."%' )";
}

$resultado_usuarios=mysqli_query($conn, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);
//Ordenar o resultado
  $result_usuarios.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $resultado_usuarios=mysqli_query($conn, $result_usuarios);

// Ler e criar o array de dados
$dados = array();
while( $row_usuarios =mysqli_fetch_array($resultado_usuarios) ) {  
	$dado = array(); 
	$dado[] = $row_usuarios["numero"];
	$dado[] = $row_usuarios["nome"];
	$dado[] = $row_usuarios["cpf"];
	$dado[] = $row_usuarios["data"];
	$dado[] = '
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
			<form class = "form-signin" role = "form" action = " " method = "post">
				<div class="modal-body">
						<h4 class = "form-signin-heading"></h4>
						<p>Nome do solicitante: <br>'.  $row_usuarios['nome'] . '</p>
						<p>Justificativa da solicitação: <br>'.  $row_usuarios['justificativa'] . '</p>
						<p>Data da Solicitação: <br>'.  $row_usuarios['data'] . '</p>
						
						<input type = "text" class = "form-control" name = "justificativa" placeholder = "motivo da rejeição">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
				</div>
			</form>
			</div>
		</div>
		</div>
		<input type="submit" name="aceita" value="Aceitar" class="btn btn-success"/>
		<input type="submit" name="rejeita" value="Rejeitar" class="btn btn-danger"/>';
	$dados[] = $dado;
}

//Cria o array de informações a serem retornadas para o Javascript
$json_data = array(
	"draw" => intval( $requestData['draw'] ),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval( $qnt_linhas ),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval( $totalFiltered ), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($json_data);  //enviar dados como formato json
?>