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
					<div class="form-inline">
						<strong class="text-info">
							帳號:
						</strong>
						<input class="form-control"/>
					</div><br>

					<div class="form-inline">
						<strong class="text-info">
							密碼:
						</strong>
						<input class="form-control"/>
					</div><br>

					<table class="table" id="button_table">
						<tr>
							<td>
								<button class="btn btn-warning">註冊</button>
							</td>
							<td>
								<a href="login.php">
									<button class="btn btn-success">登入</button>
								</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>