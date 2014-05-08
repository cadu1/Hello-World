<?php
    if (isset($_POST['id'])) {
        include("../lib/connection.php");
        
        $id = $_POST['id'];
        
        $result = mysql_query("SELECT * FROM `categoria_produto` WHERE `categoria_produto_id` = $id");
        
        $cat = mysql_fetch_row($result);
        echo implode("|", $cat);
    } else {
        echo "0|";
    }
    exit();
?>