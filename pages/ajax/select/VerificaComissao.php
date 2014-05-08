<?php
    include("../../lib/connection.php");

    $id = $_POST['vendedor'];
    $resp = "|0|Verifique se h&aacute; cadastro de comiss&atilde;o para o vendedor";

    if(!empty($id)) {
    	$result = mysql_query("SELECT `vendedor_dt_pagto` FROM `vendedor` WHERE `pessoa_id` = $id");

    	if (mysql_num_rows($result) > 0) {
            $vend = mysql_fetch_row($result);
            $data = "";

            if(date("d") > $vend[0]) {
                $data = date("d/m/Y", (strtotime("+1 month", strtotime(date("{$vend[0]}-m-Y")))));
            } else {
                $data = date("{$vend[0]}/m/Y");
            }
            
            $resp = "|1|$data";
    	}
    }
    echo $resp;
	exit();
?>