<?php
    include_once("../includes/conexao.php");

    if($_POST){
        echo "Submit RECEBIDO";
        $nome = ucwords(trim($_POST["txt_nome"]));
        $email = strtolower(trim($_POST["txt_email"]));
        $nascimento = $_POST["txt_nascimento"];
        $idCidade = $_POST["cbo_cidade"];

        $sql = "SELECT * FROM tb_amigos WHERE email ='$email'";
        $dados = mysqli_query($conecta, $sql);
        
        if($dados->num_rows == 0){
            $sql = "INSERT INTO tb_amigos(nome, email, dataNascimento, fk_cidade)
                    VALUES('$nome','$email','$nascimento',$idCidade)";
            if($conecta->query($sql) === TRUE){
                $op="success";
                $msg = "Amigo incluido com sucesso";
            }else{
                $op = "danger";
                $msg = "Amigo não foi incluido </br>Erro: ".$conecta->error;
            }
        }else{
            $op = "danger";
            $msg = "Email informado já existe na base de dados...";
        }
        header('Location: lista_simplesbkp.php?op='.base64_encode($op).'&msg='.base64_encode($msg));
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <title>Lista Inlcuir - Formulário</title>
</head>
<body>
<div class="container">
    <h1>Adicionar novo Amigo</h1>
        <form method="POST" action="lista_incluirbkp.php">
            <div class="form-group">
                <label for="txt_nome">Nome do meu amigo:</label>
                <input type="text" id="txt_nome" name="txt_nome" class="form-control" placeholder="Nome completo" required>
            </div>
            <div class="form-group">
                <label for="txt_email">E-mail do meu amigo:</label>
                <input type="email" id="txt_email" name="txt_email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="txt_nascimento">Data de nascimento do meu amigo:</label>
                <input type="date" id="txt_nascimento" name="txt_nascimento" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="cbo_cidade">Onde meu amigo mora:</label>
                <select id="cbo_cidade" name="cbo_cidade" class="form-control" required>
                    <option value=""> -- Escolha uma cidade -- </option>
<?php
                $sql = mysqli_query($conecta,"SELECT * FROM tb_cidade ORDER BY nomeCidade");
                while($row = mysqli_fetch_object($sql)){
                    echo '<option value="'.$row->pk_id.'">'.$row->nomeCidade.'</option>';
                }
?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" value="INSERT">INCLUIR NOVO AMIGO</button> 
            <a href="lista_simplesbkp.php" class="btn btn-primary" value="INSERT">CANCELAR</a>
        </form>
</div>
    <script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.js"></script>
</body>
</html>