<?php
	include ("../../lib/connection.php");

	if (isset($_POST['id']) && !empty($_POST['id'])) {
		mysql_query("DELETE FROM `origem` WHERE origem_id = {$_POST['id']}");
	}
?>