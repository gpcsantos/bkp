<?php
    include_once("../includes/conexao.php");

    if($_GET){
        $op = base64_decode($_GET['op']);
        $msg = base64_decode($_GET['msg']);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <title>Lista Simples</title>
    
</head>
<body>
<div class="container">
<?php if(isset($op)){ ?> 
    <div class="alert alert-<?php echo $op;?> alert-dismissible fade show" role="alert">
        <?php echo $msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
    <a class="btn btn-primary" href="lista_incluirbkp.php">INSERIR NOVO AMIGO</a>
    <table class="table table-striped">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Nascimento</th>
                <th>fk_cidade</th>
                <th>Ação</th>   
            </tr>
        </thead>
<?php 
        $sql = mysqli_query($conecta,"SELECT a.pk_id, nome, email, dataNascimento, nomeCidade 
            FROM tb_amigos AS a LEFT JOIN tb_cidade AS c ON c.pk_id=a.fk_cidade ORDER BY nome ASC");
        if($sql->num_rows > 0){
            while($row = mysqli_fetch_object($sql)){
?>
            <tr>
                <td><?php echo $row->pk_id; ?></td>
                <td><?php echo $row->nome; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->dataNascimento; ?></td>
                <td><?php echo $row->nomeCidade; ?></td>
                <td>
                    <!--
                    <a href="lista_alterarbkp.php?id=<?php echo $row->pk_id; ?>" class="btn btn-outline-secondary">[alterar]</a>
                    <a href="lista_excluirbkp.php?id=<?php echo $row->pk_id; ?>" class="btn btn-outline-secondary" onclick="return confirm('Deseja realmene excluir o amigo?');">[excluir]</a>
                    </br>
                    <a href="#?id=<?php echo $row->pk_id; ?>" class="btn btn-outline-secondary">[interesse]</a>
                    <a href="#?id=<?php echo $row->pk_id; ?>" class="btn btn-outline-secondary">[procura]</a>
                    </br>
                    -->
                    <select id="acao" class="form-control" onchange="encaminha(this.value, '<?php echo base64_encode($row->pk_id); ?>');">
                        <option selected>Escolha uma ação</option>
                        <option value="1">Alterar</option>
                        <option value="2">Excluir</option>
                        <option value="3">Interesse</option>
                        <option value="4">Procura</option>

                    </select>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalExcluir" data-id="<?php echo $row->pk_id ; ?>">
                        [Excluir]
                    </button>
                </td>
            </tr>
<?php 
            }
        }else{
?>
            <tr>
                <td colspan="6">Não foram encontrados registros!</td>
            </tr>
<?php 
        }
?>
    </table>

<!-- Modal -->
<div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="remover_amigo.php">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja realmente excluir o cadastro do amigo?
                <input type="hidden" name="pk_id" id="pk_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-danger">Sim</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalMensagem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo base64_decode($_GET["msg"]); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
            </div>
    </div>
  </div>
</div>



</div>
    <script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.js"></script>
    <script>
    $(function () {
        $('#modalExcluir').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            $('#pk_id').val(id);
        });
        <?php if(!empty($_GET["msg"])){ ?>
            $('#modalMensagem').modal('show');
        <?php } ?>
    });
    </script>
    <script type="text/javascript"> 
        function encaminha(v,id){                                                            
            if(v==1)
                window.location.href='lista_alterarbkp.php?id='+id; 
            else if(v==2){
                if (confirm('Deseja realmente ecluir o amigo?')){
                    window.location.href='lista_excluirbkp.php?id='+id
                }
            }
            else if(v==3)
            window.location.href='interesse.php?id='+id; 
            else if(v==4)
            window.location.href='procura.php?id='+id; 
        }                                                   
    </script> 
</body>
</html>