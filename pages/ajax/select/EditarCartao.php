<?php
	include ("../../lib/connection.php");

	$id = $_POST['id'];

    if(!empty($id)) {
        $sql = mysql_query("SELECT `c`.`cartao_credito_id`, `u`.`usuario_nome`, `c`.`cartao_credito_nome`, `c`.`cartao_credito_mes_val`, `c`.`cartao_credito_ano_val`, `c`.`cartao_credito_dia_fat`, `c`.`cartao_credito_dia_limite`, `c`.`cartao_credito_limite`, `c`.`cartao_credito_numero` FROM `cartao_credito` `c` JOIN `usuario` `u` ON `c`.`usuario_id` = `u`.`usuario_id` WHERE `c`.`cartao_credito_id` = $id");
        $result = mysql_fetch_row($sql);

        $resp = implode("~", $result);
        echo $resp;
    } else {
        echo "0~Problemas na tentativa de edi&ccedil;&atilde;o";
    }
    exit();
?>