<?php
	include ("../../lib/connection.php");

	$id = $_POST['categoria'];

    if(!empty($id)) {
        $sql = mysql_query("SELECT `c`.`categoria_id`, `c`.`categoria_nome`, CASE `c`.`categoria_tipo` WHEN 1 THEN 1 WHEN 0 THEN 2 END AS `categoria_tipo`, `c`.`id_subcategoria`, `u`.`usuario_nome` FROM `categoria` `c` JOIN `usuario` `u` ON `c`.`usuario_id` = `u`.`usuario_id` WHERE `categoria_id` = $id");
        $result = mysql_fetch_row($sql);

        $resp = implode("|", $result);
        echo $resp;
    } else {
        echo "0|Problemas na tentativa de edi&ccedil;&atilde;o";
    }
    exit();
?>