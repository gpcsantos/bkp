<?php
    include_once("../includes/conexao.php");

    if($_POST){
        $id = $_POST["id"];
        $interesses=$_POST["cbo_interesse"];
        for ($i=0;$i<count($interesses);$i++)
        {
            $consulta =  $conecta->query("SELECT * FROM rl_interesses_amigos WHERE fk_amigos = $id AND fk_interesses = $interesses[$i]");
            if($consulta->num_rows == 0 ){
                $sql = "INSERT INTO rl_interesses_amigos(fK_amigos, fk_interesses) VALUES($id,$interesses[$i])";
                $conecta->query($sql);
            }   
        }
        header('Location: interesse.php?id='.base64_encode($id));
    }else{
        header('Location: interesse.php');
    }
?>