<?php
	session_start();
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Chat</title>
		<link rel="icon" href="">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="//code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script><!-- bootstrap -->
		<script>
		$(function(){
			$("#login_btn").click(function(){
				$.ajax({
					url:"option.php?opt=login",type:"POST",dataType:"json",
					data:{
						un:$("#username").val(),
						pw:$("#password").val()
					},
					success:function(data){
						if(data.length == 0){
							alert("帳號或密碼錯誤");
						}
						else{
							location.assign("index.php");
						}
					},
					error:function(data){
						alert("error");
					}
				});
			});
		});
		</script>

		<style>
		#button_table td{
			border:none;
		}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="row">
				<br><br>
				<div class="col-sm-3">

					<?php if(!isset($_SESSION["chat_auth"])){ ?>
					<h1>
						<label class="label label-info">
							登入<?php echo "SESSION:".$_SESSION["chat_auth"]; ?>
						</label>	
					</h1>
					<br>

					<input class="form-control" placeholder="帳號" id="username" autocomplete="off"/>
					<br>

					<input class="form-control" placeholder="密碼" id="password" autocomplete="off" type="password"/>
					<br>

					<table class="table" id="button_table">
						<tr>
							<td>
								
								<button id="login_btn" class="btn btn-success">登入</button>
							</td>
							<td>
								<a href="reg.php">
									<button class="btn btn-warning">註冊</button>
								</a>
							</td>
						</tr>
					</table>
					<?php } ?>


					<?php if(isset($_SESSION["chat_auth"])){ ?>
					<h1>
						<label class="label label-danger">已登入</label>
					</h1>
					<br><br><br>

					<a href="index.php">
						<button class="btn btn-primary">回首頁</button>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>