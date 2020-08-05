<?php
    include_once("../includes/conexao.php");

    if($_GET){
        $id = base64_decode($_GET["id"]);
        $sql = "SELECT * FROM tb_amigos WHERE pk_ID = $id";
        $dados = mysqli_query($conecta,$sql);
        $row = mysqli_fetch_object($dados);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Procura - Formulário</title>
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/select2.min.css" />

    <script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/select2.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Atribui Procura ao Amigo Selecionado</h1>
        <form method="POST" action="procura_incluir.php">
            <div class="form-group">
                <label for="txt_nome">Nome do meu amigo:</label>
                <input type="text" id="txt_nome" name="txt_nome" class="form-control" value="<?php echo $row->nome; ?>" disabled>
            
            <div class="form-group">
                <label for="cbo_procura">Interesses</label>
                <select class="form-control js-example-basic-multiple" id="cbo_procura" name="cbo_procura[]"  multiple required>
                    <option value=""> -- Escolha uma ou mais interesses -- </option>
<?php
                $sql = mysqli_query($conecta,"SELECT * FROM tb_procura 
                WHERE pk_id NOT IN(SELECT fk_procura FROM `rl_procura_amigos` WHERE fk_amigos=$id )");
                while($row1 = mysqli_fetch_object($sql)){
                    echo '<option value="'.$row1->pk_id.'">'.$row1->procura.'</option>';
                }
?>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
            <button type="submit" class="btn btn-primary" name="submit" value="INSERT">SALVAR</button> 
            <a href="lista_simplesbkp.php" class="btn btn-primary">CANCELAR</a>
        </form>
        <table class="table table-striped">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Procura</th>
                <th>Ação</th>   
            </tr>
        </thead>
<?php 
        $sql = mysqli_query($conecta,"SELECT p.pk_id, p.procura 
            FROM tb_amigos AS a INNER JOIN rl_procura_amigos AS rl ON a.pk_id=rl.fk_amigos 
            INNER JOIN tb_procura AS p ON rl.fk_procura=p.pk_id 
            WHERE a.pk_id = $id ORDER BY p.procura");
        if($sql->num_rows > 0){
            while($row = mysqli_fetch_object($sql)){
?>
            <tr>
                <td><?php echo $row->pk_id; ?></td>
                <td><?php echo $row->procura; ?></td>
                <td>
                    <a href="procura_excluir.php?id=<?php echo base64_encode($id); ?>&int=<?php echo base64_encode($row->pk_id); ?>" class="btn btn-outline-secondary" onclick="return confirm('Deseja realmene excluir o interesse?');">[excluir]</a>                    
                </td>
            </tr>
<?php 
            }
        }else{
?>
            <tr>
                <td colspan="3">Não foram encontrados registros!</td>
            </tr>
<?php 
        }
?>
    </table>
</div>
    <script>
         $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    
    <script type="text/javascript" src="../js/bootstrap.bundle.js"></script>
</body>
</html>