<?php
    include_once("../includes/conexao.php");

    
    if($_GET){
        $id = base64_decode($_GET["id"]);
        $procura = base64_decode($_GET["int"]);
        $sql = "DELETE FROM rl_procura_amigos WHERE fk_amigos = $id AND fk_procura = $procura";
        $conecta->query($sql);

          
        header('Location: procura.php?id='.base64_encode($id));
    }else{
        header('Location: procura.php');

    }

?>