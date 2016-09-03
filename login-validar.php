<?php

	include"banco.php";

	session_start();

	$ipserver = $_POST['ipserver'];
	$login = $_POST['login'];
	$password = $_POST['senha'];
	$passwdebcrip = md5($password);

	$sql = "SELECT * FROM usuario WHERE login = \"$login\" AND passwdencrip = \"$passwdebcrip\"";

	if ($result = $con->query($sql)){
		while($obj = $result->fetch_object())//varre o obj result
		{
			$_SESSION['login'] = $obj->login;
			$_SESSION['password'] = $password;
			$_SESSION['logado'] = true;
			//Guardando ip para usar na conexão ssh na pagina index.php
			$_SESSION['ipserver'] = $ipserver;
			header("Location:index.php");
			exit();
		}
		if(@$_SESSION['logado']!== 1)
		{
			header("Location:login.php");
			exit();
		}
	}

?>
