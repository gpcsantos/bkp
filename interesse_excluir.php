<?php
    include_once("../includes/conexao.php");

    
    if($_GET){
        $id = base64_decode($_GET["id"]);
        $interesse = base64_decode($_GET["int"]);
        $sql = "DELETE FROM rl_interesses_amigos WHERE fk_amigos = $id AND fk_interesses = $interesse";
        $conecta->query($sql);

          
        header('Location: interesse.php?id='.base64_encode($id));
    }else{
        header('Location: interesse.php');

    }

?>