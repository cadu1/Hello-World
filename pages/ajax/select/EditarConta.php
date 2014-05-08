<?php
	include ("../../lib/connection.php");

	$id = $_POST['conta'];
    
    if(!empty($id)) {
        $sql = mysql_query("SELECT `c`.`caixa_id`, `l`.`lancamento_vencimento`, `c`.`caixa_nome`, `l`.`lancamento_valor`, `cc`.`conta_corrente_limite`, `cc`.`banco_id`, `cc`.`conta_corrente_agencia`, `cc`.`conta_corrente_num`, `u`.`usuario_nome`, `cc`.`conta_corrente_carteira`, `cc`.`conta_corrente_custo`, `cc`.`conta_corrente_linha1`, `cc`.`conta_corrente_linha2`, `cc`.`conta_corrente_linha3`, `cc`.`conta_corrente_convenio`, `l`.`lancamento_valor`, `cc`.`conta_corrente_num_dv`, `cc`.`conta_corrente_ag_dv`, `cc`.`conta_corrente_conv_dv` FROM `caixa` `c` JOIN `conta_corrente` `cc` ON `c`.`caixa_id` = `cc`.`caixa_id` JOIN `usuario` `u` ON `c`.`usuario_id` = `u`.`usuario_id` JOIN `lancamento` `l` ON `l`.`caixa_id` = `c`.`caixa_id` WHERE `c`.`caixa_id` = $id AND `l`.`categoria_id` = 1");
        $result = mysql_fetch_row($sql);

        $result[3] = number_format($result[3], 2, ",", ".");
        $result[4] = number_format($result[4], 2, ",", ".");
        $result[1] = date("d/m/Y", strtotime($result[1]));
        $result[15] = $result[15] >= 0 ? "positivo" : "negativo";

        $resp = implode("|", $result);
        echo $resp;
    } else {
        echo "0|Problemas na tentativa de edi&ccedil;&atilde;o";
    }
    exit();
?>