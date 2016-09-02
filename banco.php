<?php

	$bdServidor = 'localhost';
	$bdUsuario = 'root';
	$bdSenha = 'neujdi';
	$bdBanco = 'Easy-Dns';

	$con = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);
	if(mysqli_connect_errno($conexao)) {
		echo "Problemas para conectar ao banco. Verifique os dados.";
		die();
	}

