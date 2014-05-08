<?php
    if (isset($_POST['id'])) {
        include("../lib/connection.php");

        $id = $_POST['id'];

        $result = mysql_query("SELECT `pr`.*, `u`.`usuario_nome` AS usuario, IFNULL(`c`.`conta_nome_fantasia`,`co`.`contato_nome`) AS pessoa FROM `produto` `pr` JOIN `usuario` `u` ON `pr`.`usuario_id` = `u`.`usuario_id` LEFT JOIN `conta` `c` ON `pr`.`pessoa_id` =  `c`.`pessoa_id` LEFT JOIN `contato` `co` ON `pr`.`pessoa_id` = `co`.`pessoa_id` WHERE `produto_id` = $id");

        $cat = mysql_fetch_row($result);
        echo implode("|", $cat);
    } else {
        echo "0|";
    }
    exit();
?>