<?php
	setcookie("login", '', 0, "/");
	setcookie("nome", '', 0, "/");
	setcookie("id", '', 0, "/");
	setcookie("time", '', 0, "/");

	header("Location: http://{$_SERVER['HTTP_HOST']}/");
	exit();
?>