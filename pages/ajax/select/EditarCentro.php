<?php
	include ("../../lib/connection.php");

	$id = $_POST['centro'];

    if(!empty($id)) {
        $sql = mysql_query("SELECT `c`.`centro_custo_id`, `c`.`centro_custo_nome`, `u`.`usuario_nome` FROM `centro_custo` `c` JOIN `usuario` `u` ON `c`.`usuario_id` = `u`.`usuario_id` WHERE `centro_custo_id` = $id");
        $result = mysql_fetch_row($sql);

        $resp = implode("|", $result);
        echo $resp;
    } else {
        echo "0|Problemas na tentativa de edi&ccedil;&atilde;o";
    }
    exit();
?>