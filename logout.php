<?php

	session_start(); //iniciamos a sessão que foi aberta
	session_destroy(); //destroi a sessão
	session_unset(); //limpamos as variaveis globais das sessões
	header('Location:login.php');

?>
