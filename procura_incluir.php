<?php
    include_once("../includes/conexao.php");

    
    if($_POST){
        $id = $_POST["id"];

        $procura=$_POST["cbo_procura"];

        for ($i=0;$i<count($procura);$i++)
        {
            $consulta =  $conecta->query("SELECT * FROM rl_procura_amigos WHERE fk_amigos = $id AND fk_procura = $procura[$i]");
            if($consulta->num_rows == 0 ){
                $sql = "INSERT INTO rl_procura_amigos(fK_amigos, fk_procura) VALUES($id,$procura[$i])";
                $conecta->query($sql);
            }   
        }
        header('Location: procura.php?id='.base64_encode($id));
    }else{
        header('Location: procura.php');

    }

?>