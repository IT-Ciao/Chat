<?php
	$dsn='mysql:host=localhost;dbname=chat;charset=utf8';
	$username = 'username';
	$password = 'password';
	
	$db = new PDO(
		$dsn,$username,	$password,
		array(
		   PDO::ATTR_EMULATE_PREPARES => false,
		   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES `utf8`;"
		  )
	);
?>