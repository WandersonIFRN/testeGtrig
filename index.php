<?php
    
    $pdo = new PDO('mysql:host=localhost; dbname=testegtrigueiro;', 'root', '');
    ob_start();
    session_start();
    $msg = '';
    if (isset($_POST['login']) && !empty($_POST['username']) 
        && !empty($_POST['password'])) {
        $query_logar = "SELECT nome, senha FROM usuario WHERE (nome = '$_POST[username]' and senha = '$_POST[password]')";
        $logar = $pdo->prepare($query_logar);
        $logar->execute();
        
        if($logar->rowCount() and $logar->rowCount() != 0){
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'tutorialspoint';
            header('Location:avaliar.php');
        }else {
            echo "
            <center><div class='alert alert-danger' role='alert'>
            usuario e ou senha incorretos
            </div></center>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Requisição de Processos</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">Inicio</a>
                    
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Login
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Acesso para Administradores</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
                                <div class="modal-body">
                                        <h4 class = "form-signin-heading"></h4>
                                        <input type = "text" class = "form-control" name = "username" placeholder = "usuario" required autofocus></br>
                                        <input type = "password" class = "form-control" name = "password" placeholder = "senha" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type = "submit" name = "login" class="btn btn-primary">Entrar</button>
                                </div>
                            </form>
                        </div>
                        </div>
                        </div>
                </div>
            </nav>
        </div>
        <br />
        <div class="container">
            <h1 align="center">Requisição de Processos</h1>
            <br />

            <?php
            $pdo = new PDO('mysql:host=localhost; dbname=testegtrigueiro;', 'root', '');
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(!empty($dados['RequisitaProcesso'])){
                $query_requisitar = "SELECT processo.idproc, usuario.iduser, usuario.nome FROM usuario, processo WHERE (usuario.nome = '$dados[nome]' and usuario.email = '$dados[email]' and LOCATE(processo.numero, '$dados[numero]') and usuario.iduser = processo.usuario_fk )";
                $requisita_processo = $pdo->prepare($query_requisitar);
                $requisita_processo->execute();
                if($requisita_processo->rowCount() and $requisita_processo->rowCount() != 0){
                    while($row = $requisita_processo->fetch()) {
                        $hoje = date('d/m/Y H:i');
                        $query_requisitar_salvar = "INSERT INTO `requisicao`(`avaliado`, `data`, `justificativa`, `usuariofk`, `processofk`) VALUES (false, '$hoje', '$dados[justificativa]', '$row[iduser]', '$row[idproc]')";
                        $salva_requisicao = $pdo->prepare($query_requisitar_salvar);
                        $salva_requisicao->execute();
                        echo "
                        <div class='alert alert-success' role='alert'>
                        Requisição Efetuada com sucesso!
                        </div>
                        ";
                    }
                }else{
                    echo "
                    <div class='alert alert-danger' role='alert'>
                      O pedido falhou, nome, email ou número(s) do(s) processo(s) não conferem!
                    </div>
                    ";
                }
            }
            ?>

            <br />
            <br />
            <div class="row">
                <div class="col-md-2">

                </div>
                <div class="col-md-8">
                    <div class="form-group">
                    <form name="requita-processos" method="POST" action="">
                        <label>Nome:</label>
                        <input type="text" name="nome" id="nome" placeholder="insira seu nome aqui" class="form-control input-lg" />
                        <br />
                        <label>Email:</label>
                        <input type="text" name="email" id="email" placeholder="insira seu email cadastrado aqui" class="form-control input-lg" />
                        <br />
                        <label>justificativa:</label>
                        <input type="text" name="justificativa" id="justificativa" placeholder="motivo da requisição" class="form-control input-lg" />
                        <br />
                        <label>Números dos processos:</label>
                        <input type="text" name="numero" id="search_data" placeholder="insira o número dos processos e os selecione aqui" autocomplete="true" class="form-control input-lg" />
                        
                        <input type="submit" value="requisitar" name="RequisitaProcesso" class="btn btn-success" style="margin-top: 1em;">

                        <br />
                        <span id="processo"></span>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>// script para requisitar os numeros dos processos para o auto complete
  $(document).ready(function(){
    $('#search_data').tokenfield({
        autocomplete :{
            source: function(request, response){
                jQuery.get('fetch.php',{
                    query : request.term
                }, function(data){
                    data = JSON.parse(data);
                    response(data);
                });
            },
            delay: 100
        }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>