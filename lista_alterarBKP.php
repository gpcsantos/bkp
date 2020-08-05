<?php
    include_once("../includes/conexao.php");

    if($_GET){
        $id = base64_decode($_GET["id"]);
        $sql = "SELECT * FROM tb_amigos WHERE pk_ID = $id";

        $dados = mysqli_query($conecta,$sql);
        $row = mysqli_fetch_object($dados);
    }

    if($_POST){
        $id = $_POST["id"];
        $nome = ucwords(trim($_POST["txt_nome"]));
        $email = strtolower(trim($_POST["txt_email"]));
        $nascimento = $_POST["txt_nascimento"];
        $idCidade = $_POST["cbo_cidade"];
       
       $sql = "UPDATE tb_amigos SET nome ='$nome', email='$email', dataNascimento='$nascimento', fk_cidade=$idCidade
                WHERE pk_id=$id";
        
        if($conecta->query($sql) === TRUE){
            $op="success";
            $msg = "Cadastro do amigo alterado com sucesso";
        }else{
            $op = "danger";
            $msg = "Erro na alteração do cadastro:</br>Erro: ".$conecta->error;
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
    <h1>Alterar dados de um Amigo</h1>
        <form method="POST" action="lista_alterarbkp.php">
            <div class="form-group">
                <label for="txt_nome">Nome do meu amigo:</label>
                <input type="text" id="txt_nome" name="txt_nome" class="form-control" value="<?php echo $row->nome; ?>" required>
            </div>
            <div class="form-group">
                <label for="txt_email">E-mail do meu amigo:</label>
                <input type="email" id="txt_email" name="txt_email" class="form-control" value="<?php echo $row->email; ?>" required>
            </div>
            <div class="form-group">
                <label for="txt_nascimento">Data de nascimento do meu amigo:</label>
                <input type="date" id="txt_nascimento" name="txt_nascimento" class="form-control" value="<?php echo $row->dataNascimento; ?>" required>
            </div>
            <div class="form-group">
                <label for="cbo_cidade">Onde meu amigo mora:</label>
                <select id="cbo_cidade" name="cbo_cidade" class="form-control" required>
                    <option value=""> -- Escolha uma cidade -- </option>
<?php
                $sql = mysqli_query($conecta,"SELECT * FROM tb_cidade ORDER BY nomeCidade");
                while($row1 = mysqli_fetch_object($sql)){
                    $s = ($row->fk_cidade==$row1->pk_id) ? "selected" :"" ;
                    echo '<option value="'.$row1->pk_id.'" '.$s.'>'.$row1->nomeCidade.'</option>';
                }
?>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $row->pk_id; ?>" >
            <button type="submit" class="btn btn-primary" name="submit" value="INSERT">ALTERAR DADOS DO AMIGO</button> 
            <a href="lista_simplesbkp.php" class="btn btn-primary" value="INSERT">CANCELAR</a>
        </form>
</div>
    <script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.js"></script>
</body>
</html>