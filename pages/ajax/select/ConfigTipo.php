<?php
	include ("../../lib/connection.php");

	$id = $_POST['pai'];
    
    if(!empty($id)) {
        $sql = mysql_query("SELECT CASE `categoria_tipo` WHEN 1 THEN 1 WHEN 0 THEN 2 END FROM `categoria` WHERE `categoria_id` = $id");
        $result = mysql_fetch_row($sql);

        echo "1|" . $result[0];
    } else {
        echo "0|Ocorreu um erro";
    }
    exit();
?>