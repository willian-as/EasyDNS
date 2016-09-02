<?php

	$dsn = 'mysql:host=localhost';
	$db = new PDO($dsn, 'root', 'neujdi');
	$db->exec(file_get_contents('db.sql'));
	header('Location: login.php');
