<?php

	include "banco.php";

	$id = '';
	$name = $_POST['Name'];
	$email = $_POST['Email'];
	$login = $_POST['Login'];
	$password = $_POST['senha'];
	$confpassword = $_POST['confirmarsenha'];


	if($password===$confpassword){
		$passwdencrip = md5($password); //Função md5 criptografa a senha
	}else {
//		echo "<script type='javascript'>alert('Senhas diferentes!');";
//		echo "javascript:window.location='cadastrar.php';</script>";
//		die();

//		echo '<script language="javascript">';
//		echo 'alert("Senhas diferentes")';
//		echo '</script>';
		echo "<a href='cadastrar.php'>Voltar</a><br>";
		die("senhas diferentes");
	}


	//verificaçao se o usuario ja esta cadastrado
	$search = "SELECT * FROM usuario WHERE login = '$login'";
	$retorno = mysqli_query($con, $search);

	if(mysqli_num_rows($retorno) == 0){
		$sql = "INSERT INTO usuario VALUES(\"$id\",\"$name\", \"$email\", \"$login\", \"$passwdencrip\")";
		mysqli_query($con, $sql);
		echo "Usuario inserido com sucesso!";
		header("Location:login.php");

	}else{
		echo "<a href='cadastrar.php'>Voltar</a><br>";
		die("Usuario ja cadastrado");
	}
	$con->close();

?>
