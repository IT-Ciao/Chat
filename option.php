<?php
	include("link.php");
	switch($_GET["opt"]){
		case "login":
		login();
		break;

		case "logout":
		logout();
		break;

		case "getInfo":
		getInfo();
		break;

		case "get_chat_log":
		get_chat_log();
		break;

		case "addMsg":
		addMsg();
		break;

		case "update_info":
		update_info();
		break;
	}

	function login(){
		global $db;
		session_start();

		$sql = "SELECT Username FROM user WHERE Username = :Username AND Password = :Password;";
		$stmt = $db -> prepare($sql);
		$stmt -> execute(array(
			":Username" => $_POST["un"],
			":Password" => $_POST["pw"]
		));
		$data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		if($data[0]["Username"] == ""){
			unset($_SESSION["chat_auth"]);
			echo json_encode("[]");
		}
		if($data[0]["Username"] != ""){
			$_SESSION["chat_auth"] = $data[0]["Username"];
			echo json_encode($data);
		}
	}

	function logout(){
		global $db;
		session_start();

		unset($_SESSION["chat_auth"]);
		echo json_encode("[]");
	}

	function getInfo(){
		global $db;
		session_start();

		if(!isset($_SESSION["chat_auth"]))	header("Location:index.php");
		else{
			$sql = "SELECT Username,Nickname,Sex,Birth,City,Town FROM user WHERE Username = :Username";
			$stmt = $db -> prepare($sql);
			$stmt -> execute(array(
				":Username" => $_SESSION["chat_auth"]
			));

			$data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($data);
		}
	}

	function get_chat_log(){
		global $db;
		session_start();

		if(!isset($_SESSION["chat_auth"]))	header("Location:index.php");
		else{
			$sql = "SELECT * FROM chat WHERE Room = :Room";
			$stmt = $db -> prepare($sql);
			$stmt -> execute(array(
				":Room" => $_POST["Room"]
			));
			$data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($data);
		}
	}

	function addMsg(){
		global $db;
		session_start();

		if($_POST["User"] == "" || !isset($_SESSION["chat_auth"]))		header("Location:index.php");
		else{
			$sql = "INSERT INTO chat(User,Room,Msg,Time)
					VALUES(:User,:Room,:Msg,:Time);";
			$stmt = $db -> prepare($sql);
			$stmt -> execute(array(
				":User" => $_POST["User"],
				":Room" => $_POST["Room"],
				":Msg" => $_POST["Msg"],
				":Time" => $_POST["Time"]
			));
			echo json_encode("[]");
		}
	}

	function update_info(){
		global $db;
		session_start();

		if(!isset($_SESSION["chat_auth"]))	header("Location:index.php");
		else{
			$sql = "UPDATE user SET
					Nickname=:Nickname,Sex=:Sex,Birth=:Birth,City=:City,Town=:Town
					WHERE Username=:Username;";
			$stmt = $db -> prepare($sql);
			$stmt -> execute(array(
				":Nickname" => $_POST["Nickname"],
				":Sex" => $_POST["Sex"],
				":Birth" => $_POST["Birth"],
				":City" => $_POST["City"],
				":Town" => $_POST["Town"],
				":Username" => $_POST["Username"]
			));
			echo json_encode("[]");
		}
	}
?>