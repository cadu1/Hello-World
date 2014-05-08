<?php
    include("../../lib/connection.php");

    $id = $_POST['centro'];

    if($id) {
        $query = mysql_query("DELETE FROM `centro_custo` WHERE `centro_custo_id` = $id");

        if($query) {
            echo '1|Exclu&iacute;do com sucesso';
        } else {
            echo '0|Problemas ao excluir';
        }
    }

    exit();
?>