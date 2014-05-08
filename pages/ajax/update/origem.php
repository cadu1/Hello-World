<?php
	include ("../../lib/connection.php");

	if (isset($_POST['id']) && !empty($_POST['id'])) {
		if (isset($_POST['nome']) && !empty($_POST['nome'])) {
			mysql_query("UPDATE `origem` SET origem_nome = '{$_POST['nome']}' WHERE origem_id = {$_POST['id']}");
			echo $_POST['nome'];
		}
	}
?>