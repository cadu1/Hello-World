<?php
	include ("pages/lib/connection.php");

	$login = $_POST['email'];
	$senha = $_POST['senha'];

	if (empty($_POST['email']) || empty($_POST['senha'])) {
		session_start();
		$_SESSION['msg'] = "Informe um usuário e/ou uma senha!";
		header("Location: http://{$_SERVER['HTTP_HOST']}");
		die();
	}

	$login = stripslashes($login);
	$senha = stripslashes($senha);
	$login = mysql_real_escape_string($login);
	$senha = md5(mysql_real_escape_string($senha));

	$result = mysql_query("SELECT * FROM `usuario` WHERE `usuario_email` = '$login' AND `usuario_senha`= '$senha'");

	if (mysql_num_rows($result) > 0) {
		$usuario = mysql_fetch_array($result);

		setcookie("login", $login, time() + 86400, "/");
		setcookie("nome", $usuario['usuario_nome'], time() + 86400, "/");
		setcookie("id", $usuario['usuario_id'], time() + 86400, "/");
		setcookie("time", time() + 900, time() + 86400, "/");

		header("Location: http://{$_SERVER['HTTP_HOST']}/home");
		exit();
	} else {
		session_start();
		$_SESSION['msg'] = "Usuário e/ou uma senha incorreto!";
		header("Location: http://{$_SERVER['HTTP_HOST']}/");
		die();
	}
?>