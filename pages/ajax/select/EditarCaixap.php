<?php
	include ("../../lib/connection.php");

	$id = $_POST['conta'];
    
    if(!empty($id)) {
        $sql = mysql_query("SELECT `c`.`caixa_id`, `l`.`lancamento_vencimento`, `c`.`caixa_nome`, `l`.`lancamento_valor`, `u`.`usuario_nome` FROM `caixa` `c` LEFT JOIN `conta_corrente` `cc` ON `c`.`caixa_id` = `cc`.`caixa_id` JOIN `usuario` `u` ON `c`.`usuario_id` = `u`.`usuario_id` JOIN `lancamento` `l` ON `l`.`caixa_id` = `c`.`caixa_id` WHERE `c`.`caixa_id` = $id AND `l`.`categoria_id` = 1 AND `cc`.`caixa_id` IS NULL");
        $result = mysql_fetch_row($sql);

        $result[1] = date("d/m/Y", strtotime($result[1]));
        $result[3] = number_format($result[3], 2, ",", ".");

        $resp = implode("|", $result);
        echo $resp;
    } else {
        echo "0|Problemas na tentativa de edição";
    }
    exit();
?>