<?php
    if (isset($_POST['id'])) {
        include("../lib/connection.php");
        
        $id = $_POST['id'];
        
        $result = mysql_query("SELECT `um`.*, `u`.`usuario_nome` FROM `unidade_medida` um JOIN `usuario` u ON `um`.`usuario_id` = `u`.`usuario_id` WHERE `unidade_medida_id` = $id");
        
        $cat = mysql_fetch_row($result);
        echo implode("|", $cat);
    } else {
        echo "0|";
    }
    exit();
?>